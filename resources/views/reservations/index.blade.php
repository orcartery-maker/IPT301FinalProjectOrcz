
@extends('layouts.app')

@section('title', 'Reservations')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Reservations</h2>
        <p class="text-muted mb-0">Manage badminton court reservations and payments.</p>
    </div>

    <a href="{{ route('reservations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Reservation
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Court</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Reservation</th>
                        <th>Payment</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>
                                <span class="fw-semibold">
                                    {{ $reservation->booking_reference }}
                                </span>
                            </td>

                            <td>
                                {{ $reservation->customer->name ?? 'Customer unavailable' }}
                            </td>

                            <td>
                                {{ $reservation->slot->courtTime->court->name ?? 'Court unavailable' }}
                            </td>

                            <td>
                                @if($reservation->slot && $reservation->slot->slot_date)
                                    {{ $reservation->slot->slot_date->format('M d, Y') }}
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                @if($reservation->slot)
                                    {{ \Carbon\Carbon::parse($reservation->slot->start_time)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::parse($reservation->slot->end_time)->format('h:i A') }}
                                @else
                                    —
                                @endif
                            </td>

                            <td class="fw-semibold">
                                ₱{{ number_format((float) $reservation->total_amount, 2) }}
                            </td>

                            <td>
                                @php
                                    $reservationBadge = match ($reservation->reservation_status) {
                                        'confirmed' => 'success',
                                        'pending' => 'warning',
                                        'cancelled' => 'secondary',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge text-bg-{{ $reservationBadge }}">
                                    {{ ucfirst($reservation->reservation_status) }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $paymentBadge = match ($reservation->payment_status) {
                                        'paid' => 'success',
                                        'refunded' => 'info',
                                        'unpaid' => 'warning',
                                        default => 'secondary',
                                    };
                                @endphp

                                <span class="badge text-bg-{{ $paymentBadge }}">
                                    {{ ucfirst($reservation->payment_status) }}
                                </span>
                            </td>

                            <td class="text-end text-nowrap">
                                <a href="{{ route('reservations.show', $reservation) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="View reservation">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('reservations.edit', $reservation) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Edit reservation">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('reservations.destroy', $reservation) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete reservation">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="bi bi-calendar-x fs-2 text-muted"></i>
                                <p class="fw-semibold mt-2 mb-1">No reservations found</p>
                                <p class="text-muted mb-3">Create a reservation to see it listed here.</p>

                                <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-sm">
                                    Add Reservation
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reservations->hasPages())
            <div class="mt-4">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
