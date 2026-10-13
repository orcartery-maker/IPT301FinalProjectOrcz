<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('customer', 'slot.courtTime.court')
            ->latest()
            ->paginate(12);

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        return view('reservations.form', [
            'reservation' => new Reservation(),
            'customers' => Customer::orderBy('name')->get(),
            'slots' => Slot::with('courtTime.court')
                ->where('status', 'available')
                ->orderBy('slot_date')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($data) {
            $slot = Slot::whereKey($data['slot_id'])->lockForUpdate()->firstOrFail();

            if ($slot->status !== 'available' || $slot->reservations()->whereIn('reservation_status', ['pending', 'confirmed'])->exists()) {
                throw ValidationException::withMessages([
                    'slot_id' => 'This slot is no longer available. Please choose another slot.',
                ]);
            }

            $data['booking_reference'] = 'BCR-' . Str::upper(Str::random(10));
            $data['total_amount'] = $slot->courtTime->court->hourly_rate;
            $data['paid_at'] = $data['payment_status'] === 'paid' ? now() : null;

            Reservation::create($data);
            $slot->update(['status' => 'reserved']);
        });

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('customer', 'slot.courtTime.court');

        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.form', [
            'reservation' => $reservation,
            'customers' => Customer::orderBy('name')->get(),
            'slots' => Slot::with('courtTime.court')
                ->where(function ($query) use ($reservation) {
                    $query->where('status', 'available')
                        ->orWhere('id', $reservation->slot_id);
                })
                ->orderBy('slot_date')
                ->get(),
        ]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($data, $reservation) {
            $oldSlot = Slot::whereKey($reservation->slot_id)->lockForUpdate()->firstOrFail();
            $newSlot = Slot::whereKey($data['slot_id'])->lockForUpdate()->firstOrFail();

            if ((int) $newSlot->id !== (int) $oldSlot->id) {
                if ($newSlot->status !== 'available' || $newSlot->reservations()
                    ->whereIn('reservation_status', ['pending', 'confirmed'])
                    ->exists()) {
                    throw ValidationException::withMessages([
                        'slot_id' => 'This slot is no longer available.',
                    ]);
                }
            }

            $active = $data['reservation_status'] !== 'cancelled';

            $data['total_amount'] = $newSlot->courtTime->court->hourly_rate;
            $data['paid_at'] = $data['payment_status'] === 'paid'
                ? ($reservation->paid_at ?? now())
                : null;

            $reservation->update($data);

            if ((int) $newSlot->id !== (int) $oldSlot->id) {
                $oldSlot->update(['status' => 'available']);
            }

            $newSlot->update([
                'status' => $active ? 'reserved' : 'available',
            ]);
        });

        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        DB::transaction(function () use ($reservation) {
            $slot = Slot::whereKey($reservation->slot_id)->lockForUpdate()->firstOrFail();

            $reservation->delete();

            $stillReserved = $slot->reservations()
                ->whereIn('reservation_status', ['pending', 'confirmed'])
                ->exists();

            if (! $stillReserved) {
                $slot->update(['status' => 'available']);
            }
        });

        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'slot_id' => [
                'required',
                'exists:slots,id',
                Rule::unique('reservations', 'slot_id')
                    ->where(fn ($query) => $query->whereIn('reservation_status', ['pending', 'confirmed']))
                    ->ignore($request->route('reservation')?->id),
            ],
            'reservation_status' => 'required|in:pending,confirmed,cancelled',
            'payment_method' => 'required|in:cash,gcash,maya,bank_transfer',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'notes' => 'nullable|string|max:2000',
        ]);
    }
}