
@extends('layouts.app')

@section('content')
@php($editing = isset($court))
<div class="mb-4"><a href="{{ route('courts.index') }}" class="text-decoration-none text-secondary">← Courts</a><h2 class="fw-bold mt-2">{{ $editing ? 'Edit Court' : 'Add Court' }}</h2></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form method="POST" action="{{ $editing ? route('courts.update',$court) : route('courts.store') }}">
@csrf
@if($editing) @method('PUT') @endif
<div class="mb-3"><label class="form-label">Court Name</label><input name="name" class="form-control" value="{{ old('name',$court->name ?? '') }}" required>@error('name')<div class="text-danger small">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$court->description ?? '') }}</textarea>@error('description')<div class="text-danger small">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Hourly Rate (₱)</label><input type="number" name="hourly_rate" min="0" step="0.01" class="form-control" value="{{ old('hourly_rate',$court->hourly_rate ?? '') }}" required>@error('hourly_rate')<div class="text-danger small">{{ $message }}</div>@enderror</div>
<div class="mb-4"><label class="form-label">Status</label><select name="status" class="form-select" required><option value="available" @selected(old('status',$court->status ?? 'available') === 'available')>Available</option><option value="unavailable" @selected(old('status',$court->status ?? '') === 'unavailable')>Unavailable</option></select>@error('status')<div class="text-danger small">{{ $message }}</div>@enderror</div>
<button class="btn btn-success">{{ $editing ? 'Save Changes' : 'Create Court' }}</button> <a href="{{ route('courts.index') }}" class="btn btn-light">Cancel</a>
</form></div></div>
@endsection
