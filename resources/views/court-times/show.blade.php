
@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('court-times.index') }}" class="text-decoration-none text-secondary">← Court Schedules</a>
    <h2 class="fw-bold mt-2">Schedule Details</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h4 class="fw-bold">{{ $courtTime->court->name }}</h4>
        <p class="text-secondary">{{ $courtTime->schedule_date->format('l, F d, Y') }}</p>
        <p>Start: <strong>{{ \Carbon\Carbon::parse($courtTime->start_time)->format('g:i A') }}</strong></p>
        <p>End: <strong>{{ \Carbon\Carbon::parse($courtTime->end_time)->format('g:i A') }}</strong></p>
        <p>Total slots: <strong>{{ $courtTime->slots->count() }}</strong></p>
        <a href="{{ route('court-times.edit',$courtTime) }}" class="btn btn-success">Edit Schedule</a>
    </div>
</div>
@endsection
