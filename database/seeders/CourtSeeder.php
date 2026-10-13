<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        $courts = [
            [
                'name' => 'Court 1',
                'description' => 'Professional badminton court.',
                'hourly_rate' => 200,
                'status' => 'available',
            ],
            [
                'name' => 'Court 2',
                'description' => 'Indoor badminton court.',
                'hourly_rate' => 180,
                'status' => 'available',
            ],
            [
                'name' => 'Court 3',
                'description' => 'Standard badminton court.',
                'hourly_rate' => 150,
                'status' => 'available',
            ],
            [
                'name' => 'Court 4',
                'description' => 'Premium badminton court.',
                'hourly_rate' => 250,
                'status' => 'available',
            ],
        ];

        foreach ($courts as $court) {
            Court::updateOrCreate(
                ['name' => $court['name']],
                $court
            );
        }
    }
}