<?php

namespace Tests\Feature;

use App\Enums\CallResultEnum;
use App\Enums\LeadStatusEnum;
use App\Models\Call;
use App\Models\Lead;

use App\Models\Manager;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CallTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register_call_creates_call_and_updates_lead_status()
    {
        $manager = Manager::factory()->create();
        $lead = Lead::factory()->create([
            'status' => LeadStatusEnum::NEW,
            'manager_id' => null,
        ]);

        $payload = [
            'duration' => 60,
            'result' => CallResultEnum::SUCCESS->value,
            'manager_id' => $manager->id,
        ];

        $this->postJson("/api/leads/{$lead->id}/calls", $payload)
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'call' => [
                    'duration' => 60,
                    'result' => CallResultEnum::SUCCESS->value,
                ]
            ]);

        $lead->refresh();

        $this->assertEquals(LeadStatusEnum::WON, $lead->status);

        $this->assertEquals($manager->id, $lead->manager_id);

        $this->assertDatabaseHas('calls', [
            'lead_id' => $lead->id,
            'duration' => 60,
            'result' => CallResultEnum::SUCCESS->value,
        ]);
    }


    public function test_three_consecutive_no_answer_calls_marks_lead_lost()
    {
        $lead = Lead::factory()->create([
            'status' => LeadStatusEnum::IN_PROGRESS,
        ]);

        Call::factory(2)->create([
            'lead_id' => $lead->id,
            'result' => CallResultEnum::NO_ANSWER,
        ]);

        $manager = Manager::factory()->create();

        $payload = [
            'duration' => 10,
            'result' => CallResultEnum::NO_ANSWER->value,
            'manager_id' => $manager->id,
        ];

        $this->postJson("/api/leads/{$lead->id}/calls", $payload)
            ->assertCreated();

        $lead->refresh();
        $this->assertEquals(LeadStatusEnum::LOST, $lead->status);
    }

}
