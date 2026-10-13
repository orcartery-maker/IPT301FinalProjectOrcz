<?php

namespace Database\Factories;

use App\Models\CourtTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlotFactory extends Factory
{
    public function definition(): array
    {
        $startHour = fake()->numberBetween(8, 11);

        return [
            'court_time_id' => CourtTime::factory(),
            'slot_date' => fake()->dateTimeBetween('tomorrow', '+7 days')->format('Y-m-d'),
            'start_time' => sprintf('%02d:00:00', $startHour),
            'end_time' => sprintf('%02d:00:00', $startHour + 1),
            'status' => 'available',
        ];
    }
}