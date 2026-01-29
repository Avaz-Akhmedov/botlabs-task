<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadCallRequest;
use App\Http\Resources\CallResource;
use App\Models\Lead;
use App\Services\CallService;
use Illuminate\Http\JsonResponse;

class CallController extends Controller
{
    public function __construct(protected CallService $callService)
    {
    }

    public function __invoke(StoreLeadCallRequest $request, Lead $lead): JsonResponse
    {
        $call = $this->callService->registerCall
        (
            $lead,
            $request->safe()->except('manager_id'),
            $request->integer('manager_id')
        );

        return response()->json([
            'success' => true,
            'call' => CallResource::make($call->load('lead'))
        ],201);
    }
}
