<?php

use App\Http\Controllers\CourtController;
use App\Http\Controllers\CourtTimeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SlotController;
use App\Models\Court;
use App\Models\CourtTime;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Slot;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $stats = [
        'customers' => Customer::count(),
        'courts' => Court::count(),
        'schedules' => CourtTime::count(),
        'slots' => Slot::count(),
        'reservations' => Reservation::count(),
        'pending' => Reservation::where('reservation_status', 'pending')->count(),
        'confirmed' => Reservation::where('reservation_status', 'confirmed')->count(),
        'revenue' => Reservation::where('payment_status', 'paid')
            ->where('reservation_status', '!=', 'cancelled')
            ->sum('total_amount'),
    ];

    $recentReservations = Reservation::with('customer', 'slot.courtTime.court')
        ->latest()
        ->take(6)
        ->get();

    $availableSlots = Slot::where('status', 'available')->count();

    return view('dashboard', compact('stats', 'recentReservations', 'availableSlots'));
})->name('dashboard');

Route::resource('customers', CustomerController::class);
Route::resource('courts', CourtController::class);
Route::resource('court-times', CourtTimeController::class);
Route::resource('slots', SlotController::class);
Route::resource('reservations', ReservationController::class);