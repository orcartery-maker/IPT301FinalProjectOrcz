
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Court Schedules</h2>
        <p class="text-secondary mb-0">Manage court operating dates and hours.</p>
    </div>
    <a href="{{ route('court-times.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Add Schedule
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Court</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Slots</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courtTimes as $schedule)
                <tr>
                    <td class="fw-semibold">{{ $schedule->court->name }}</td>
                    <td>{{ $schedule->schedule_date->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
                    <td>{{ $schedule->slots_count }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('court-times.show',$schedule) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('court-times.edit',$schedule) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('court-times.destroy',$schedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this schedule?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-secondary py-4">No schedules found.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $courtTimes->links() }}
    </div>
</div>
@endsection
