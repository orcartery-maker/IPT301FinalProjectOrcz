
@extends('layouts.app')

@section('content')
@php($editing = isset($courtTime))

<div class="mb-4">
    <a href="{{ route('court-times.index') }}" class="text-decoration-none text-secondary">← Court Schedules</a>
    <h2 class="fw-bold mt-2">{{ $editing ? 'Edit Schedule' : 'Add Schedule' }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ $editing ? route('court-times.update',$courtTime) : route('court-times.store') }}">
            @csrf
            @if($editing) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label">Court</label>
                <select name="court_id" class="form-select" required>
                    <option value="">Select a court</option>
                    @foreach($courts as $court)
                    <option value="{{ $court->id }}" @selected((string)old('court_id',$courtTime->court_id ?? '') === (string)$court->id)>
                        {{ $court->name }}
                    </option>
                    @endforeach
                </select>
                @error('court_id')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Schedule Date</label>
                <input type="date" name="schedule_date" class="form-control" value="{{ old('schedule_date',isset($courtTime) ? $courtTime->schedule_date->format('Y-m-d') : '') }}" required>
                @error('schedule_date')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time',isset($courtTime) ? substr($courtTime->start_time,0,5) : '') }}" required>
                    @error('start_time')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time',isset($courtTime) ? substr($courtTime->end_time,0,5) : '') }}" required>
                    @error('end_time')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <button class="btn btn-success">{{ $editing ? 'Save Changes' : 'Create Schedule' }}</button>
            <a href="{{ route('court-times.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
