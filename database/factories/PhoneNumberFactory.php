<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneNumberFactory extends Factory
{

    public function definition(): array
    {
        return [
            'phone' => fake()->unique()->numerify('##########'),
        ];
    }
}
