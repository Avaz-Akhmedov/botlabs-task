<?php

namespace Database\Factories;

use App\Enums\LeadStatusEnum;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;


class LeadFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(LeadStatusEnum::values()),
            'manager_id' => Manager::query()->inRandomOrder()->first()->id
        ];
    }
}
