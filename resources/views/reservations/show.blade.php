
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <a href="{{ route('reservations.index') }}" class="text-decoration-none text-secondary">
            <i class="bi bi-arrow-left"></i> Reservations
        </a>
        <h2 class="fw-bold mt-2 mb-1">Reservation Details</h2>
        <p class="text-secondary mb-0">{{ $reservation->booking_reference }}</p>
    </div>

    <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-success">
        <i class="bi bi-pencil"></i> Edit Reservation
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                    <div>
                        <div class="text-secondary small mb-1">Booking Reference</div>
                        <h4 class="fw-bold mb-0">{{ $reservation->booking_reference }}</h4>
                    </div>
                    <span class="badge {{ $reservation->reservation_status === 'confirmed' ? 'bg-success' : ($reservation->reservation_status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }} fs-6">
                        {{ ucfirst($reservation->reservation_status) }}
                    </span>
                </div>

                <h5 class="fw-bold mb-3">Booking Information</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-secondary small">Customer</div>
                        <div class="fw-semibold">{{ $reservation->customer->name }}</div>
                        <div class="small text-secondary">{{ $reservation->customer->email }}</div>
                        <div class="small text-secondary">{{ $reservation->customer->phone ?: 'No phone number' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary small">Court</div>
                        <div class="fw-semibold">{{ $reservation->slot->courtTime->court->name }}</div>
                        <div class="small text-secondary">
                            {{ $reservation->slot->slot_date->format('l, F d, Y') }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary small">Start Time</div>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($reservation->slot->start_time)->format('g:i A') }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary small">End Time</div>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($reservation->slot->end_time)->format('g:i A') }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary small">Date Created</div>
                        <div class="fw-semibold">{{ $reservation->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Payment Information</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-secondary small">Total Amount</div>
                        <h3 class="fw-bold mb-0">₱{{ number_format((float)$reservation->total_amount, 2) }}</h3>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary small">Payment Status</div>
                        <div class="mt-1">
                            <span class="badge {{ $reservation->payment_status === 'paid' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                {{ ucfirst($reservation->payment_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary small">Payment Method</div>
                        <div class="fw-semibold">{{ $reservation->payment_method ? ucwords(str_replace('_', ' ', $reservation->payment_method)) : 'Not specified' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary small">Paid At</div>
                        <div class="fw-semibold">
                            {{ $reservation->paid_at ? $reservation->paid_at->format('M d, Y h:i A') : 'Not yet paid' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($reservation->notes)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-2">Notes</h5>
                <p class="mb-0">{{ $reservation->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Reservation Summary</h5>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Booking</span>
                    <span class="fw-semibold">#{{ $reservation->id }}</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Reservation</span>
                    <span class="fw-semibold">{{ ucfirst($reservation->reservation_status) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Payment</span>
                    <span class="fw-semibold">{{ ucfirst($reservation->payment_status) }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Total</span>
                    <h4 class="fw-bold mb-0">₱{{ number_format((float)$reservation->total_amount, 2) }}</h4>
                </div>

                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-success w-100 mt-4">
                    Manage Reservation
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
