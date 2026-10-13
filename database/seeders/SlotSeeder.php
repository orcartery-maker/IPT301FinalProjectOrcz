<?php

namespace Database\Seeders;

use App\Models\CourtTime;
use App\Models\Slot;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    public function run(): void
    {
        $courtTimes = CourtTime::all();

        foreach ($courtTimes as $courtTime) {
            for ($hour = 8; $hour < 12; $hour++) {
                Slot::firstOrCreate(
                    [
                        'court_time_id' => $courtTime->id,
                        'slot_date' => $courtTime->schedule_date->toDateString(),
                        'start_time' => sprintf('%02d:00:00', $hour),
                        'end_time' => sprintf('%02d:00:00', $hour + 1),
                    ],
                    [
                        'status' => 'available',
                    ]
                );
            }
        }
    }
}