<?php

namespace Database\Factories;

use App\Enums\CallResultEnum;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;


class CallFactory extends Factory
{

    public function definition(): array
    {
        return [
            'lead_id' => Lead::factory(),
            'duration' => rand(1, 1999),
            'result' => $this->faker->randomElement(CallResultEnum::values())
        ];
    }
}
