<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'duration' => $this->duration,
            'result' => $this->result,
            'lead' => LeadResource::make($this->whenLoaded('lead')),
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
