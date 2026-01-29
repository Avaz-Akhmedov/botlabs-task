<?php

namespace App\Http\Requests;

use App\Enums\CallResultEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreLeadCallRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'duration' => ['required', 'integer', 'min:0'],
            'result' => ['required', new Enum(CallResultEnum::class),],
            'manager_id' => ['required', 'exists:managers,id','integer']
        ];
    }
}
