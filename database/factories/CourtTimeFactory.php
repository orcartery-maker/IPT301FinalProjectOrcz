<?php

namespace Database\Factories;

use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtTimeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'court_id' => Court::factory(),
            'schedule_date' => fake()->dateTimeBetween('tomorrow', '+7 days')->format('Y-m-d'),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
        ];
    }
}