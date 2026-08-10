<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriPlan - @yield('title', 'Personal Meal Planner')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        :root {
            --primary:   #2d6a4f;
            --primary2:  #40916c;
            --primary3:  #52b788;
            --soft:      #95d5b2;
            --bg:        #f0faf4;
            --sidebar-w: 260px;
        }

        body {
            background: linear-gradient(135deg, #f0faf4 0%, #ffffff 50%, #e8f5f0 100%);
            min-height: 100vh;
            color: #1a2e22;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(45,106,79,0.12);
            position: fixed;
            top: 0; left: 0;
            z-index: 200;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        .sidebar.collapsed { transform: translateX(-100%); }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(45,106,79,0.1);
            background: linear-gradient(135deg, var(--primary), var(--primary2));
        }

        .sidebar-brand h4 { color: white; font-weight: 700; margin: 0; font-size: 1.3rem; }
        .sidebar-brand span { color: #b7e4c7; }
        .sidebar-brand small { color: rgba(255,255,255,0.6); font-size: 0.72rem; }

        .sidebar-nav { padding: 0.75rem 0; }

        .sidebar-nav .nav-link {
            color: #4a7c59;
            padding: 0.7rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
            font-size: 0.875rem;
            border-left: 3px solid transparent;
            font-weight: 400;
        }

        .sidebar-nav .nav-link:hover {
            color: var(--primary);
            background: rgba(45,106,79,0.07);
            border-left-color: rgba(45,106,79,0.3);
        }

        .sidebar-nav .nav-link.active {
            color: var(--primary);
            background: rgba(45,106,79,0.1);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .sidebar-nav .nav-link > i { font-size: 1.05rem; width: 20px; flex-shrink: 0; }
        .sidebar-nav hr { border-color: rgba(45,106,79,0.1); margin: 0.5rem 1.5rem; }

        /* ── Main Content ── */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            transition: margin 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        .main-content.expanded { margin-left: 0; }

        /* ── Topbar ── */
        .topbar {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 0.85rem 1.5rem;
            border-bottom: 1px solid rgba(45,106,79,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0; z-index: 99;
        }

        .toggle-btn {
            background: rgba(45,106,79,0.08);
            border: 1px solid rgba(45,106,79,0.15);
            color: var(--primary);
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .toggle-btn:hover { background: rgba(45,106,79,0.15); }

        .content-area { padding: 1.5rem; }

        /* ── Cards ── */
        .card {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(45,106,79,0.1);
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(45,106,79,0.06);
            color: #1a2e22;
        }

        .card-header {
            background: rgba(240,250,244,0.9);
            border-bottom: 1px solid rgba(45,106,79,0.08);
            border-radius: 16px 16px 0 0 !important;
            font-weight: 600;
            color: var(--primary);
            padding: 1rem 1.25rem;
        }

        /* ── Stat Cards ── */
        .stat-card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(45,106,79,0.1);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 16px rgba(45,106,79,0.06);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(45,106,79,0.12);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 90px; height: 90px;
            border-radius: 50%;
            background: rgba(45,106,79,0.05);
            transform: translate(25px,-25px);
        }

        .stat-number { font-size: 2rem; font-weight: 700; color: var(--primary); line-height: 1; }
        .stat-label { color: #6b9e7e; font-size: 0.8rem; margin-top: 0.25rem; }
        .stat-icon { font-size: 2rem; opacity: 0.4; }

        /* ── Buttons ── */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border: none; border-radius: 10px; font-weight: 500;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1b4332, var(--primary));
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(45,106,79,0.3);
            color: white;
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: rgba(45,106,79,0.35);
            border-radius: 10px;
        }

        .btn-outline-primary:hover {
            background: rgba(45,106,79,0.08);
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-secondary {
            color: #6b9e7e;
            border-color: rgba(45,106,79,0.2);
            border-radius: 10px;
        }

        .btn-outline-secondary:hover {
            background: rgba(45,106,79,0.06);
            color: var(--primary);
            border-color: rgba(45,106,79,0.3);
        }

        .btn-outline-danger {
            color: #dc3545;
            border-color: rgba(220,53,69,0.25);
            border-radius: 10px;
        }

        .btn-outline-danger:hover {
            background: rgba(220,53,69,0.06);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--primary), var(--primary3));
            border: none; border-radius: 10px;
        }

        .btn-outline-success {
            color: var(--primary);
            border-color: rgba(45,106,79,0.3);
            border-radius: 10px;
        }

        /* ── Badges ── */
        .badge-goal { padding: 0.4rem 0.9rem; border-radius: 20px; font-size: 0.78rem; font-weight: 500; }
        .badge-diet { background: rgba(45,106,79,0.12); color: var(--primary); border: 1px solid rgba(45,106,79,0.2); }
        .badge-maintenance { background: rgba(59,130,246,0.1); color: #1d4ed8; border: 1px solid rgba(59,130,246,0.2); }
        .badge-bulking { background: rgba(245,158,11,0.12); color: #b45309; border: 1px solid rgba(245,158,11,0.2); }

        /* ── Alert ── */
        .alert { border-radius: 12px; }
        .alert-success { background: rgba(45,106,79,0.1); color: var(--primary); border: 1px solid rgba(45,106,79,0.2) !important; }
        .alert-danger { background: rgba(220,53,69,0.08); color: #dc3545; border: 1px solid rgba(220,53,69,0.2) !important; }

        /* ── Form ── */
        .form-control, .form-select {
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(45,106,79,0.2);
            color: #1a2e22;
            border-radius: 10px;
        }

        .form-control:focus, .form-select:focus {
            background: white;
            border-color: var(--primary2);
            box-shadow: 0 0 0 3px rgba(45,106,79,0.1);
            color: #1a2e22;
        }

        .form-control::placeholder { color: #aac4b2; }
        .form-label { color: #3a6b4a; font-size: 0.85rem; font-weight: 500; }

        .input-group-text {
            background: rgba(45,106,79,0.07);
            border: 1px solid rgba(45,106,79,0.2);
            color: var(--primary);
        }

        /* ── Table ── */
        .table { color: #1a2e22; }
        .table-light { background: rgba(240,250,244,0.8) !important; color: var(--primary); }
        .table > :not(caption) > * > * {
            background: transparent;
            border-bottom-color: rgba(45,106,79,0.07);
            color: #2d4a38;
        }
        .table-hover > tbody > tr:hover > * { background: rgba(45,106,79,0.04); }

        /* ── Progress ── */
        .progress { background: rgba(45,106,79,0.1); border-radius: 10px; }
        .progress-bar { background: linear-gradient(90deg, var(--primary), var(--primary3)); border-radius: 10px; }

        /* ── Misc ── */
        .badge.bg-light { background: rgba(45,106,79,0.08) !important; color: var(--primary) !important; }
        .bg-success-subtle { background: rgba(45,106,79,0.08) !important; }
        .text-success { color: var(--primary2) !important; }
        .text-muted { color: #7aaa8a !important; }

        /* ── Modal ── */
        .modal-content {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(45,106,79,0.15);
            border-radius: 16px;
            color: #1a2e22;
        }
        .modal-header, .modal-footer { border-color: rgba(45,106,79,0.1); }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(45,106,79,0.2); border-radius: 3px; }

        /* ── Overlay ── */
        .sidebar-overlay {
            display: none;
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.25);
            z-index: 150;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .sidebar.collapsed { transform: translateX(-100%); }
            .main-content { margin-left: 0 !important; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h4>🥗 Nutri<span>Plan</span></h4>
        <small>Personal Meal Planner</small>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('meal-plans.index') }}"
           class="nav-link {{ request()->routeIs('meal-plans*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Meal Plan
        </a>
        <a href="{{ route('weight-logs.index') }}"
           class="nav-link {{ request()->routeIs('weight-logs*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> Weight Tracker
        </a>
        <a href="{{ route('foods.index') }}"
           class="nav-link {{ request()->routeIs('foods*') ? 'active' : '' }}">
            <i class="bi bi-egg-fried"></i> Browse Makanan
        </a>
        <a href="{{ route('favorites.index') }}"
           class="nav-link {{ request()->routeIs('favorites*') ? 'active' : '' }}">
            <i class="bi bi-heart"></i> Favorit
        </a>
        <hr>
        <a href="{{ route('about') }}"
           class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
            <i class="bi bi-info-circle"></i> About
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <div class="toggle-btn" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </div>
            <h6 class="mb-0 fw-semibold" style="color: var(--primary);">
                @yield('page-title', 'Dashboard')
            </h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-goal badge-{{ auth()->user()->goal ?? 'maintenance' }}">
                {{ ucfirst(auth()->user()->goal ?? 'maintenance') }}
            </span>
            <span style="color: #6b9e7e; font-size: 0.85rem;">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="content-area pb-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="content-area">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const sidebar     = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn   = document.getElementById('sidebarToggle');
    const overlay     = document.getElementById('sidebarOverlay');
    const isMobile    = () => window.innerWidth <= 768;

    toggleBtn.addEventListener('click', function() {
        if (isMobile()) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    });

    overlay.addEventListener('click', function() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
</script>

@stack('scripts')
</body>
</html>