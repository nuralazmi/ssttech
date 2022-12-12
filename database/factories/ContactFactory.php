<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'company_id' => rand(1,20),
            'photo' => fake()->imageUrl()
        ];
    }
}
