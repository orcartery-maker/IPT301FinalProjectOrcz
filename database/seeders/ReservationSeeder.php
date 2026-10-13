<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Slot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            return;
        }

        $slots = Slot::where('status', 'available')
            ->orderBy('id')
            ->take(8)
            ->get();

        foreach ($slots as $index => $slot) {
            $court = $slot->courtTime->court;
            $isPaid = $index < 3;
            $isConfirmed = $index < 5;

            Reservation::create([
                'customer_id' => $customers->random()->id,
                'slot_id' => $slot->id,
                'booking_reference' => 'BCR-' . Str::upper(Str::random(10)),
                'total_amount' => $court->hourly_rate,
                'reservation_status' => $isConfirmed ? 'confirmed' : 'pending',
                'payment_method' => ['cash', 'gcash', 'maya', 'bank_transfer'][$index % 4],
                'payment_status' => $isPaid ? 'paid' : 'unpaid',
                'paid_at' => $isPaid ? now() : null,
                'notes' => 'Sample reservation',
            ]);

            $slot->update([
                'status' => 'reserved',
            ]);
        }
    }
}