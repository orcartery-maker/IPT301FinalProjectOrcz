
@extends('layouts.app')

@section('content')
@php($editing = isset($reservation) && $reservation->exists)

<div class="mb-4">
    <a href="{{ route('reservations.index') }}" class="text-decoration-none text-secondary">
        <i class="bi bi-arrow-left"></i> Reservations
    </a>
    <h2 class="fw-bold mt-2">{{ $editing ? 'Edit Reservation' : 'New Reservation' }}</h2>
    <p class="text-secondary mb-0">Manage the booking and payment information.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST"
            action="{{ $editing ? route('reservations.update', $reservation) : route('reservations.store') }}">
            @csrf
            @if($editing)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">Select a customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            @selected((string)old('customer_id', $reservation->customer_id ?? '') === (string)$customer->id)>
                            {{ $customer->name }} — {{ $customer->email }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Time Slot</label>
                <select name="slot_id" class="form-select" required>
                    <option value="">Select a time slot</option>
                    @foreach($slots as $slot)
                        <option value="{{ $slot->id }}"
                            @selected((string)old('slot_id', $reservation->slot_id ?? '') === (string)$slot->id)>
                            {{ $slot->courtTime->court->name }} —
                            {{ $slot->slot_date->format('M d, Y') }} —
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}
                            to {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                            @if($editing && (int)$slot->id === (int)$reservation->slot_id)
                                (Current slot)
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('slot_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                <div class="form-text">The amount is calculated automatically from the court's hourly rate.</div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Reservation Status</label>
                    <select name="reservation_status" class="form-select" required>
                        @foreach(['pending'=>'Pending','confirmed'=>'Confirmed','cancelled'=>'Cancelled'] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('reservation_status', $reservation->reservation_status ?? 'pending') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('reservation_status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select" required>
                        @foreach(['unpaid'=>'Unpaid','paid'=>'Paid','refunded'=>'Refunded'] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('payment_status', $reservation->payment_status ?? 'unpaid') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-select">
                    <option value="">Not specified</option>
                    @foreach(['cash'=>'Cash','gcash'=>'GCash','maya'=>'Maya','bank_transfer'=>'Bank Transfer'] as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('payment_method', $reservation->payment_method ?? '') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="3"
                    placeholder="Optional booking notes">{{ old('notes', $reservation->notes ?? '') }}</textarea>
                @error('notes')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-success">
                {{ $editing ? 'Save Changes' : 'Create Reservation' }}
            </button>
            <a href="{{ route('reservations.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
