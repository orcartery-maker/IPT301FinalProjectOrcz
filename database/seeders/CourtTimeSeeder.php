<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\CourtTime;
use Illuminate\Database\Seeder;

class CourtTimeSeeder extends Seeder
{
    public function run(): void
    {
        $courts = Court::all();

        for ($day = 1; $day <= 3; $day++) {
            $date = now()->addDays($day)->toDateString();

            foreach ($courts as $court) {
                CourtTime::updateOrCreate(
                    [
                        'court_id' => $court->id,
                        'schedule_date' => $date,
                        'start_time' => '08:00:00',
                        'end_time' => '12:00:00',
                    ],
                    []
                );
            }
        }
    }
}