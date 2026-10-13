<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,
            CourtSeeder::class,
            CourtTimeSeeder::class,
            SlotSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}