
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="fw-bold mb-1">Courts</h2><p class="text-secondary mb-0">Manage courts and hourly rates.</p></div>
    <a href="{{ route('courts.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> Add Court</a>
</div>
<div class="card border-0 shadow-sm"><div class="card-body table-responsive">
<table class="table align-middle">
<thead><tr><th>Court</th><th>Hourly Rate</th><th>Status</th><th>Schedules</th><th class="text-end">Actions</th></tr></thead>
<tbody>
@forelse($courts as $court)
<tr>
<td><strong>{{ $court->name }}</strong><div class="small text-secondary">{{ Str::limit($court->description, 55) }}</div></td>
<td>₱{{ number_format((float)$court->hourly_rate, 2) }}</td>
<td><span class="badge {{ $court->status === 'available' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($court->status) }}</span></td>
<td>{{ $court->court_times_count }}</td>
<td class="text-end text-nowrap">
<a class="btn btn-sm btn-outline-secondary" href="{{ route('courts.show',$court) }}"><i class="bi bi-eye"></i></a>
<a class="btn btn-sm btn-outline-primary" href="{{ route('courts.edit',$court) }}"><i class="bi bi-pencil"></i></a>
<form class="d-inline" method="POST" action="{{ route('courts.destroy',$court) }}" onsubmit="return confirm('Delete this court?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-secondary py-4">No courts found.</td></tr>
@endforelse
</tbody></table>
{{ $courts->links() }}
</div></div>
@endsection
