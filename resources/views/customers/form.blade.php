
@extends('layouts.app')

@section('content')
@php($editing = isset($customer))
<div class="mb-4">
    <a href="{{ route('customers.index') }}" class="text-decoration-none text-secondary"><i class="bi bi-arrow-left"></i> Customers</a>
    <h2 class="fw-bold mt-2">{{ $editing ? 'Edit Customer' : 'Add Customer' }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ $editing ? route('customers.update', $customer) : route('customers.store') }}" method="POST">
            @csrf
            @if($editing) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input name="name" value="{{ old('name', $customer->name ?? '') }}" class="form-control" required maxlength="255">
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}" class="form-control" required>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="form-label">Phone Number</label>
                <input name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="form-control">
                @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <button class="btn btn-success">{{ $editing ? 'Save Changes' : 'Create Customer' }}</button>
            <a href="{{ route('customers.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
