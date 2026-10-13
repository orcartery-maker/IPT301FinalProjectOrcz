<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourtFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Court ' . fake()->unique()->numberBetween(1, 999),
            'description' => fake()->sentence(),
            'hourly_rate' => fake()->randomElement([150, 180, 200, 250]),
            'status' => 'available',
        ];
    }
}