
@extends('layouts.app')

@section('content')
<div class="mb-4"><a href="{{ route('courts.index') }}" class="text-decoration-none text-secondary">← Courts</a><h2 class="fw-bold mt-2">{{ $court->name }}</h2></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<p>{{ $court->description ?: 'No description provided.' }}</p>
<h4 class="fw-bold">₱{{ number_format((float)$court->hourly_rate,2) }} <small class="text-secondary fs-6">per hour</small></h4>
<p>Status: <strong>{{ ucfirst($court->status) }}</strong></p>
<a href="{{ route('courts.edit',$court) }}" class="btn btn-success">Edit Court</a>
</div></div>
<div class="card border-0 shadow-sm mt-4"><div class="card-body"><h5 class="fw-bold">Schedules</h5>
@forelse($court->courtTimes as $schedule)
<div class="border-bottom py-3">{{ $schedule->schedule_date->format('M d, Y') }} · {{ $schedule->start_time }}–{{ $schedule->end_time }}</div>
@empty<p class="text-secondary mb-0">No schedules for this court yet.</p>@endforelse
</div></div>
@endsection
