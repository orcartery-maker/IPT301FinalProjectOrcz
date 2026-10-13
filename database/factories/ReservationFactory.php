<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'slot_id' => Slot::factory(),
            'booking_reference' => 'BCR-' . Str::upper(Str::random(10)),
            'total_amount' => 200,
            'reservation_status' => 'pending',
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
            'paid_at' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}