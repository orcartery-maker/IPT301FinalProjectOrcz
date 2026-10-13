
@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('slots.index') }}" class="text-decoration-none text-secondary">← Time Slots</a>
    <h2 class="fw-bold mt-2">Time Slot Details</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h4 class="fw-bold">{{ $slot->courtTime->court->name }}</h4>
        <p class="text-secondary">{{ $slot->slot_date->format('l, F d, Y') }}</p>
        <p>Start: <strong>{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}</strong></p>
        <p>End: <strong>{{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</strong></p>
        <p>Status:
            <span class="badge {{ $slot->status === 'available' ? 'bg-success' : ($slot->status === 'reserved' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                {{ ucfirst($slot->status) }}
            </span>
        </p>

        <a href="{{ route('slots.edit',$slot) }}" class="btn btn-success">Edit Time Slot</a>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Reservations for This Slot</h5>
        @forelse($slot->reservations as $reservation)
        <div class="border-bottom py-3">
            <a href="{{ route('reservations.show',$reservation) }}" class="fw-semibold text-decoration-none">
                {{ $reservation->booking_reference }}
            </a>
            <div class="small text-secondary">
                {{ $reservation->customer->name }} ·
                ₱{{ number_format((float)$reservation->total_amount,2) }} ·
                {{ ucfirst($reservation->reservation_status) }}
            </div>
        </div>
        @empty
        <p class="text-secondary mb-0">No reservations for this slot.</p>
        @endforelse
    </div>
</div>
@endsection
