<?php

namespace App\Services;

use App\Enums\CallResultEnum;
use App\Enums\LeadStatusEnum;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class CallService
{
public function registerCall(Lead $lead, array $callData, int $managerId)
{
    return DB::transaction(function () use ($lead, $callData, $managerId) {

        $call = $lead->calls()->create($callData);
        $lead->load('calls');

        $isFirstCall = $lead->calls()->count() === 1;


        if ($isFirstCall && $lead->status === LeadStatusEnum::NEW) {
            $lead->status = LeadStatusEnum::IN_PROGRESS;
        }

        if (is_null($lead->manager_id)) {
            $lead->manager_id = $managerId;
        }

        if ($call->result === CallResultEnum::SUCCESS) {
            $lead->status = LeadStatusEnum::WON;
        }


        if ($lead->status !== LeadStatusEnum::WON && $lead->status !== LeadStatusEnum::LOST) {
            $this->checkLostCondition($lead);
        }

        if ($lead->isDirty()) {
            $lead->save();
        }

        return $call;

    });
}

private function checkLostCondition(Lead $lead): void
{
    $lastThreeCalls = $lead->calls()
        ->latest()
        ->take(3)
        ->get();

    if ($lastThreeCalls->count() < 3) {
        return;
    }

    $allNoAnswer = $lastThreeCalls->every(
        fn($call) => $call->result === CallResultEnum::NO_ANSWER
    );

    if ($allNoAnswer) {
        $lead->status = LeadStatusEnum::LOST;
    }
}
}
