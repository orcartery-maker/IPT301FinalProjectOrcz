
@extends('layouts.app')

@section('content')
@php($editing = isset($slot) && $slot->exists)

<div class="mb-4">
    <a href="{{ route('slots.index') }}" class="text-decoration-none text-secondary">← Time Slots</a>
    <h2 class="fw-bold mt-2">{{ $editing ? 'Edit Time Slot' : 'Add Time Slot' }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ $editing ? route('slots.update', $slot) : route('slots.store') }}">
            @csrf
            @if($editing)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Court Schedule</label>
                <select name="court_time_id" class="form-select" required>
                    <option value="">Select a schedule</option>
                    @foreach($courtTimes as $schedule)
                        <option value="{{ $schedule->id }}"
                            @selected((string)old('court_time_id', $slot->court_time_id ?? '') === (string)$schedule->id)>
                            {{ $schedule->court->name }} —
                            {{ $schedule->schedule_date->format('M d, Y') }}
                            ({{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}
                            – {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }})
                        </option>
                    @endforeach
                </select>
                @error('court_time_id')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Slot Date</label>
                <input type="date" name="slot_date" class="form-control"
                    value="{{ old('slot_date', $editing ? $slot->slot_date->format('Y-m-d') : '') }}" required>
                @error('slot_date')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control"
                        value="{{ old('start_time', $editing ? substr($slot->start_time, 0, 5) : '') }}" required>
                    @error('start_time')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time" class="form-control"
                        value="{{ old('end_time', $editing ? substr($slot->end_time, 0, 5) : '') }}" required>
                    @error('end_time')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="available" @selected(old('status', $slot->status ?? 'available') === 'available')>Available</option>
                    <option value="unavailable" @selected(old('status', $slot->status ?? '') === 'unavailable')>Unavailable</option>
                </select>
                @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <button class="btn btn-success">{{ $editing ? 'Save Changes' : 'Create Time Slot' }}</button>
            <a href="{{ route('slots.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
