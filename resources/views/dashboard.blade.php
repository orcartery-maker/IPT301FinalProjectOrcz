@extends('layouts.app')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard')

@section('content')
    <div class="page-heading">
        <div>
            <h2 class="page-title">Good day, Administrator <span>👋</span></h2>
            <p class="page-subtitle">Here's what's happening at your badminton facility.</p>
        </div>
        <a href="{{ route('reservations.create') }}" class="btn btn-lime">
            <i class="bi bi-plus-lg me-2"></i>New reservation
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-label">Total customers</div>
                <div class="stat-value">{{ number_format($stats['customers']) }}</div>
                <div class="stat-note">Registered customers</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-dribbble"></i></div>
                <div class="stat-label">Total courts</div>
                <div class="stat-value">{{ number_format($stats['courts']) }}</div>
                <div class="stat-note">Registered badminton courts</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                <div class="stat-label">Reservations</div>
                <div class="stat-value">{{ number_format($stats['reservations']) }}</div>
                <div class="stat-note">{{ $stats['pending'] }} awaiting confirmation</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                <div class="stat-label">Paid revenue</div>
                <div class="stat-value" style="font-size:25px">₱{{ number_format($stats['revenue'], 2) }}</div>
                <div class="stat-note">From non-cancelled paid reservations</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h3 class="panel-title">Reservation overview</h3>
                        <div class="subtext mt-1">Current booking status</div>
                    </div>
                    <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-soft">View all <i class="bi bi-arrow-up-right ms-1"></i></a>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#f0f7e6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small">Confirmed</span>
                                    <i class="bi bi-check-circle text-success fs-5"></i>
                                </div>
                                <div class="fs-2 fw-bold mt-2">{{ $stats['confirmed'] }}</div>
                                <div class="subtext">Confirmed reservations</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#fff6e6">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small">Pending</span>
                                    <i class="bi bi-hourglass-split text-warning fs-5"></i>
                                </div>
                                <div class="fs-2 fw-bold mt-2">{{ $stats['pending'] }}</div>
                                <div class="subtext">Need review</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#eef4fc">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small">Available slots</span>
                                    <i class="bi bi-clock text-primary fs-5"></i>
                                </div>
                                <div class="fs-2 fw-bold mt-2">{{ $availableSlots }}</div>
                                <div class="subtext">Open for reservation</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#f5f0fc">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-secondary small">Court schedules</span>
                                    <i class="bi bi-calendar-week fs-5" style="color:#7655ad"></i>
                                </div>
                                <div class="fs-2 fw-bold mt-2">{{ $stats['schedules'] }}</div>
                                <div class="subtext">Scheduled court periods</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="{{ route('customers.create') }}" class="btn btn-outline-soft btn-sm"><i class="bi bi-person-plus me-1"></i>Add customer</a>
                        <a href="{{ route('courts.create') }}" class="btn btn-outline-soft btn-sm"><i class="bi bi-plus-circle me-1"></i>Add court</a>
                        <a href="{{ route('slots.create') }}" class="btn btn-outline-soft btn-sm"><i class="bi bi-clock me-1"></i>Create slot</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="panel h-100">
                <div class="panel-header">
                    <h3 class="panel-title">Quick actions</h3>
                </div>
                <div class="panel-body d-flex flex-column gap-3">
                    <a href="{{ route('reservations.create') }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark p-2 rounded-3">
                        <span class="stat-icon mb-0"><i class="bi bi-journal-plus"></i></span>
                        <span class="flex-grow-1">
                            <span class="d-block fw-bold">Create reservation</span>
                            <span class="subtext">Book an available court slot</span>
                        </span>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </a>
                    <a href="{{ route('court-times.create') }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark p-2 rounded-3">
                        <span class="stat-icon mb-0"><i class="bi bi-calendar-plus"></i></span>
                        <span class="flex-grow-1">
                            <span class="d-block fw-bold">Add court schedule</span>
                            <span class="subtext">Set a date and operating period</span>
                        </span>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </a>
                    <a href="{{ route('slots.index') }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark p-2 rounded-3">
                        <span class="stat-icon mb-0"><i class="bi bi-clock-history"></i></span>
                        <span class="flex-grow-1">
                            <span class="d-block fw-bold">Manage time slots</span>
                            <span class="subtext">Review availability</span>
                        </span>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </a>
                    <a href="{{ route('reservations.index') }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark p-2 rounded-3">
                        <span class="stat-icon mb-0"><i class="bi bi-credit-card"></i></span>
                        <span class="flex-grow-1">
                            <span class="d-block fw-bold">Review payments</span>
                            <span class="subtext">Manage payment status</span>
                        </span>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <h3 class="panel-title">Recent reservations</h3>
                <div class="subtext mt-1">The latest bookings recorded in the system</div>
            </div>
            <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-soft">All reservations <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Booking reference</th>
                        <th>Customer</th>
                        <th>Court / date</th>
                        <th>Amount</th>
                        <th>Booking status</th>
                        <th>Payment</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReservations as $reservation)
                        <tr>
                            <td><span class="reference-code">{{ $reservation->booking_reference }}</span></td>
                            <td>
                                <div class="person-cell">
                                    <div class="person-avatar">{{ strtoupper(substr($reservation->customer->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="person-name">{{ $reservation->customer->name }}</div>
                                        <div class="subtext">{{ $reservation->customer->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $reservation->slot->courtTime->court->name }}</div>
                                <div class="subtext">{{ $reservation->slot->slot_date->format('M d, Y') }} · {{ substr($reservation->slot->start_time, 0, 5) }}</div>
                            </td>
                            <td class="fw-bold">₱{{ number_format($reservation->total_amount, 2) }}</td>
                            <td><span class="status-badge status-{{ $reservation->reservation_status }}">{{ ucfirst($reservation->reservation_status) }}</span></td>
                            <td><span class="status-badge status-{{ $reservation->payment_status }}">{{ ucfirst($reservation->payment_status) }}</span></td>
                            <td>
                                <a href="{{ route('reservations.show', $reservation) }}" class="action-btn" title="View reservation"><i class="bi bi-arrow-up-right"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty-state"><i class="bi bi-journal-x"></i>No reservations yet.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection