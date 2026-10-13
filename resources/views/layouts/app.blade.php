<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Courtly</title>
    <meta name="theme-color" content="#101a2b">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #101a2b;
            --navy-soft: #18263b;
            --lime: #c7f36b;
            --lime-dark: #a8d948;
            --ink: #182334;
            --muted: #7b8798;
            --line: #e9edf2;
            --surface: #ffffff;
            --page: #f5f7fa;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--page);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        h1, h2, h3, h4, h5, h6, .brand-name {
            font-family: 'Manrope', sans-serif;
            letter-spacing: -.035em;
        }

        .app-shell { min-height: 100vh; }

        .sidebar {
            width: 258px;
            background: var(--navy);
            color: #fff;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1040;
            padding: 25px 17px;
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 10px 29px;
            color: #fff;
            text-decoration: none;
        }

        .brand-mark {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            color: var(--navy);
            background: var(--lime);
            border-radius: 14px;
            font-size: 22px;
        }

        .brand-name { font-size: 20px; font-weight: 800; line-height: 1.1; }
        .brand-sub { color: #91a0b5; font-size: 10px; margin-top: 5px; letter-spacing: .13em; text-transform: uppercase; }

        .nav-label {
            color: #7f8ca0;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .15em;
            padding: 13px 13px 9px;
        }

        .sidebar .nav-link {
            color: #aab6c7;
            display: flex;
            align-items: center;
            gap: 13px;
            border-radius: 11px;
            padding: 12px 13px;
            margin: 2px 0;
            font-weight: 600;
            transition: .2s ease;
        }

        .sidebar .nav-link i { font-size: 17px; width: 20px; text-align: center; }
        .sidebar .nav-link:hover { background: #1c2a3f; color: #fff; }
        .sidebar .nav-link.active { background: var(--lime); color: var(--navy); }
        .sidebar .nav-link.active i { color: var(--navy); }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid #28364a;
            padding: 18px 10px 0;
        }

        .sidebar-bottom .system-status {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #bdc8d7;
            font-size: 12px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--lime);
            display: inline-block;
        }

        .main-area { margin-left: 258px; min-height: 100vh; }

        .topbar {
            min-height: 78px;
            padding: 15px 34px;
            background: #fff;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .topbar-kicker { font-size: 11px; color: var(--muted); margin-bottom: 4px; }
        .topbar-title { font-weight: 800; font-size: 20px; margin: 0; }
        .topbar-avatar {
            width: 39px;
            height: 39px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            background: #edf4df;
            color: #45641a;
            font-weight: 800;
        }

        .page-content { padding: 30px 34px 40px; max-width: 1600px; margin: auto; }
        .page-heading { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 25px; flex-wrap: wrap; }
        .page-title { font-size: 27px; font-weight: 800; margin: 0 0 7px; }
        .page-subtitle { color: var(--muted); margin: 0; font-size: 13px; }

        .btn-lime {
            background: var(--lime);
            border: 1px solid var(--lime);
            color: var(--navy);
            border-radius: 10px;
            font-weight: 700;
            padding: 10px 16px;
        }

        .btn-lime:hover { background: var(--lime-dark); border-color: var(--lime-dark); color: var(--navy); }
        .btn-outline-soft { border: 1px solid #dfe5ec; border-radius: 9px; background: white; color: #344154; font-weight: 600; }
        .btn-outline-soft:hover { background: #f5f7fa; }

        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(18, 32, 51, .025);
        }

        .panel-header {
            padding: 20px 22px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .panel-title { font-size: 15px; font-weight: 800; margin: 0; }
        .panel-body { padding: 22px; }

        .stat-card {
            background: white;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            width: 75px;
            height: 75px;
            position: absolute;
            right: -24px;
            top: -25px;
            border-radius: 50%;
            background: #f3f7ea;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: #f0f5e6;
            color: #4c681d;
            font-size: 19px;
            margin-bottom: 19px;
        }

        .stat-label { color: var(--muted); font-size: 12px; font-weight: 600; }
        .stat-value { font-size: 29px; font-weight: 800; margin-top: 5px; line-height: 1.2; }
        .stat-note { font-size: 11px; color: #8a95a5; margin-top: 7px; }

        .table { --bs-table-bg: transparent; margin-bottom: 0; }
        .table thead th {
            background: #f8fafc;
            color: #7b8798;
            text-transform: uppercase;
            letter-spacing: .07em;
            font-size: 10px;
            font-weight: 800;
            padding: 14px 17px;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        .table tbody td { padding: 15px 17px; border-color: #f0f2f5; vertical-align: middle; }
        .table tbody tr:last-child td { border-bottom: 0; }
        .table tbody tr:hover { background: #fbfcfd; }

        .person-cell { display: flex; align-items: center; gap: 11px; min-width: 170px; }
        .person-avatar {
            width: 36px;
            height: 36px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            background: #edf2f8;
            color: #354b69;
            font-size: 12px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .person-name { font-weight: 700; color: var(--ink); }
        .subtext { font-size: 11px; color: var(--muted); margin-top: 3px; }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 20px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-available, .status-paid, .status-confirmed { background: #eaf7e7; color: #36753a; }
        .status-reserved, .status-pending, .status-unpaid { background: #fff4dc; color: #966718; }
        .status-cancelled, .status-refunded, .status-maintenance { background: #ffebeb; color: #ae4545; }

        .action-group { display: flex; gap: 6px; justify-content: flex-end; }
        .action-btn {
            width: 32px; height: 32px;
            display: inline-grid; place-items: center;
            border: 1px solid #e7ebf0;
            border-radius: 9px;
            background: white; color: #647185;
            text-decoration: none;
        }
        .action-btn:hover { color: #17263b; background: #f2f5f8; }
        .action-btn.danger:hover { color: #c03939; background: #fff1f1; }

        .form-label { font-size: 12px; font-weight: 700; color: #39475a; margin-bottom: 8px; }
        .form-control, .form-select {
            border-color: #dfe5ec;
            border-radius: 10px;
            padding: 11px 13px;
            font-size: 13px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #9fc94e;
            box-shadow: 0 0 0 .2rem rgba(199, 243, 107, .25);
        }
        .form-hint { font-size: 11px; color: var(--muted); margin-top: 6px; }
        .form-section-title { font-weight: 800; font-size: 14px; margin: 0 0 18px; }

        .alert { border: 0; border-radius: 12px; }
        .pagination { margin: 0; }
        .page-link { border-color: #e5eaf0; color: #344154; }
        .page-item.active .page-link { background: var(--navy); border-color: var(--navy); }
        .empty-state { text-align: center; padding: 48px 20px; color: var(--muted); }
        .empty-state i { font-size: 30px; display: block; margin-bottom: 12px; color: #a8b2c0; }
        .reference-code { font-family: monospace; color: #3e5b1d; background: #f1f7e7; padding: 5px 7px; border-radius: 6px; font-size: 12px; }
        .footer-note { text-align: center; color: #9aa4b2; font-size: 11px; padding-top: 28px; }

        @media (max-width: 991.98px) {
            .sidebar { width: 75px; padding: 20px 9px; }
            .brand { justify-content: center; padding: 5px 0 25px; }
            .brand-copy, .nav-label, .sidebar .nav-link span, .sidebar-bottom { display: none; }
            .sidebar .nav-link { justify-content: center; padding: 13px 5px; }
            .sidebar .nav-link i { font-size: 19px; }
            .main-area { margin-left: 75px; }
            .topbar { padding: 14px 22px; }
            .page-content { padding: 25px 22px; }
        }

        @media (max-width: 575.98px) {
            .topbar { padding: 13px 15px; min-height: 68px; }
            .topbar-title { font-size: 17px; }
            .page-content { padding: 20px 13px 30px; }
            .page-title { font-size: 23px; }
            .stat-card { padding: 15px; }
            .stat-value { font-size: 24px; }
            .panel-header, .panel-body { padding: 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand">
            <span class="brand-mark"><i class="bi bi-trophy-fill"></i></span>
            <span class="brand-copy">
                <span class="brand-name d-block">COURTLY</span>
                <span class="brand-sub d-block">Court management</span>
            </span>
        </a>

        <div class="nav-label">Workspace</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
            </a>
        </nav>

        <div class="nav-label mt-3">Management</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <i class="bi bi-people"></i><span>Customers</span>
            </a>
            <a class="nav-link {{ request()->routeIs('courts.*') ? 'active' : '' }}" href="{{ route('courts.index') }}">
                <i class="bi bi-dribbble"></i><span>Courts</span>
            </a>
            <a class="nav-link {{ request()->routeIs('court-times.*') ? 'active' : '' }}" href="{{ route('court-times.index') }}">
                <i class="bi bi-calendar-week"></i><span>Court schedules</span>
            </a>
            <a class="nav-link {{ request()->routeIs('slots.*') ? 'active' : '' }}" href="{{ route('slots.index') }}">
                <i class="bi bi-clock-history"></i><span>Time slots</span>
            </a>
            <a class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}" href="{{ route('reservations.index') }}">
                <i class="bi bi-journal-check"></i><span>Reservations</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="system-status"><span class="status-dot"></span> System ready</div>
            <div class="subtext mt-2">Courtly · Reservation system</div>
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div>
                <div class="topbar-kicker">BADMINTON COURT RESERVATION SYSTEM</div>
                <h1 class="topbar-title">@yield('topbar-title', 'Dashboard')</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold">System Administrator</div>
                    <div class="subtext">Management workspace</div>
                </div>
                <div class="topbar-avatar"><i class="bi bi-person-fill"></i></div>
            </div>
        </header>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <div class="fw-bold mb-2"><i class="bi bi-exclamation-triangle me-1"></i> Please check the following:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <div class="footer-note">COURTLY · Badminton Court Reservation System · Laravel Final Project</div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>