
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Time Slots</h2>
        <p class="text-secondary mb-0">Manage individual court booking times.</p>
    </div>
    <a href="{{ route('slots.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Add Time Slot
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Court</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($slots as $slot)
                <tr>
                    <td class="fw-semibold">{{ $slot->courtTime->court->name }}</td>
                    <td>{{ $slot->slot_date->format('M d, Y') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}
                        –
                        {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                    </td>
                    <td>
                        <span class="badge
                            {{ $slot->status === 'available' ? 'bg-success' : ($slot->status === 'reserved' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ ucfirst($slot->status) }}
                        </span>
                    </td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('slots.show',$slot) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('slots.edit',$slot) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('slots.destroy',$slot) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this time slot?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-secondary py-4">No time slots found.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $slots->links() }}
    </div>
</div>
@endsection
