<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{


    public function __invoke(StoreLeadRequest $request): JsonResponse
    {
        $lead = Lead::query()->create($request->validated());


        return response()->json([
            'success' => true,
            'lead' => LeadResource::make($lead)
        ],201);
    }
}
