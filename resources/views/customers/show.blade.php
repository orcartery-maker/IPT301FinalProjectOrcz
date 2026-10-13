
@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('customers.index') }}" class="text-decoration-none text-secondary"><i class="bi bi-arrow-left"></i> Customers</a>
    <h2 class="fw-bold mt-2">Customer Details</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h4 class="fw-bold">{{ $customer->name }}</h4>
        <p class="text-secondary mb-1">{{ $customer->email }}</p>
        <p class="mb-3">{{ $customer->phone ?: 'No phone number' }}</p>
        <p>Reservations: <strong>{{ $customer->reservations->count() }}</strong></p>
        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-success">Edit Customer</a>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Reservation History</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Reference</th><th>Date</th><th>Amount</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($customer->reservations as $reservation)
                    <tr>
                        <td><a href="{{ route('reservations.show', $reservation) }}">{{ $reservation->booking_reference }}</a></td>
                        <td>{{ $reservation->created_at->format('M d, Y') }}</td>
                        <td>₱{{ number_format((float)$reservation->total_amount, 2) }}</td>
                        <td>{{ ucfirst($reservation->reservation_status) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-secondary text-center">No reservations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
