<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MailAddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->email,
        ];
    }
}
