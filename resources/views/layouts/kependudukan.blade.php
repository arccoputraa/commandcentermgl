<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kependudukan') - Command Center Magelang</title>
    <link rel="icon" href="{{ asset('images/cmdcenterlogo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <aside class="admin-sidebar" style="background-color:#0f172a;">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('images/cmdcenterlogo.png') }}" alt="Logo Command Center" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            </div>
            <h2>MagelangCC</h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('kependudukan.dashboard') }}" class="menu-item {{ request()->routeIs('kependudukan.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> Dashboard Kependudukan
            </a>
            <a href="{{ route('kependudukan.data-penduduk.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-penduduk.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Data Penduduk
            </a>
            <a href="{{ route('kependudukan.data-agama.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-agama.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wave-square"></i> Data Agama
            </a>
            <a href="{{ route('kependudukan.data-wilayah.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-wilayah.*') ? 'active' : '' }}">
                <i class="fa-solid fa-location-dot"></i> Data Wilayah
            </a>
            <a href="{{ route('kependudukan.data-kartu-keluarga.index') }}" class="menu-item {{ request()->routeIs('kependudukan.data-kartu-keluarga.*') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> Data Kartu Keluarga
            </a>
            <a href="{{ route('kependudukan.mutasi-penduduk.index') }}" class="menu-item {{ request()->routeIs('kependudukan.mutasi-penduduk.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wave-square"></i> Mutasi Penduduk
            </a>
            <a href="{{ route('kependudukan.informasi-terbaru.index') }}" class="menu-item {{ request()->routeIs('kependudukan.informasi-terbaru.*') ? 'active' : '' }}">
                <i class="fa-solid fa-download"></i> Informasi Terbaru
            </a>
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-regular fa-circle-user"></i> Profil
            </a>
        </nav>
        <div class="sidebar-menu" style="flex-grow:0; padding-top:0;">
            <a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <h2 class="topbar-title">Command Center</h2>
            </div>
            <div class="topbar-profile">
                <div class="profile-info">
                    <h4>{{ Auth::user()->name ?? 'Admin Kependudukan' }}</h4>
                    <p>{{ Auth::user()->division->name ?? 'User Kependudukan' }}</p>
                </div>
                <div class="profile-img">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>
        </header>

        <div class="admin-content kependudukan-content">
            @yield('content')
        </div>
    </main>

    <style>
        .kependudukan-content .kependudukan-header,
        .kependudukan-content .resident-header,
        .kependudukan-content .religion-header,
        .kependudukan-content .area-header,
        .kependudukan-content .kk-header,
        .kependudukan-content .mutation-header,
        .kependudukan-content .info-header,
        .kependudukan-content .form-header,
        .kependudukan-content .detail-header {
            margin-bottom: 24px !important;
        }

        .kependudukan-content h1.profile-title,
        .kependudukan-content .kependudukan-header h2,
        .kependudukan-content .resident-header h2,
        .kependudukan-content .religion-header h2,
        .kependudukan-content .area-header h2,
        .kependudukan-content .kk-header h2,
        .kependudukan-content .mutation-header h2,
        .kependudukan-content .info-header h2,
        .kependudukan-content .form-header h2,
        .kependudukan-content .detail-header h2 {
            font-size: 24px !important;
            line-height: 1.25 !important;
            margin-bottom: 8px !important;
        }

        .kependudukan-content .kependudukan-header p,
        .kependudukan-content .resident-header p,
        .kependudukan-content .religion-header p,
        .kependudukan-content .area-header p,
        .kependudukan-content .kk-header p,
        .kependudukan-content .mutation-header p,
        .kependudukan-content .info-header p,
        .kependudukan-content .form-header p,
        .kependudukan-content .detail-header p {
            font-size: 14px !important;
            line-height: 1.5 !important;
        }

        .kependudukan-content .add-button,
        .kependudukan-content .edit-button,
        .kependudukan-content .back-button,
        .kependudukan-content .btn-back,
        .kependudukan-content .btn-save,
        .kependudukan-content .btn-cancel,
        .kependudukan-content .btn-edit-profile,
        .kependudukan-content .btn-logout-profile {
            min-width: 0 !important;
            height: auto !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            gap: 8px !important;
        }

        .kependudukan-content .filter-card {
            gap: 12px !important;
            padding: 8px !important;
            margin-bottom: 24px !important;
            border-radius: 12px !important;
        }

        .kependudukan-content .filter-input,
        .kependudukan-content .filter-select,
        .kependudukan-content .filter-button,
        .kependudukan-content .filter-card select,
        .kependudukan-content .filter-card button,
        .kependudukan-content .form-group input,
        .kependudukan-content .form-group select {
            height: 40px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
        }

        .kependudukan-content .search-field i {
            left: 16px !important;
            font-size: 14px !important;
        }

        .kependudukan-content .filter-input {
            padding-left: 42px !important;
        }

        .kependudukan-content .table-card,
        .kependudukan-content .form-card,
        .kependudukan-content .detail-card,
        .kependudukan-content .panel-card,
        .kependudukan-content .metric-card,
        .kependudukan-content .profile-card {
            border-radius: 12px !important;
        }

        .kependudukan-content .resident-table th,
        .kependudukan-content .religion-table th,
        .kependudukan-content .area-table th,
        .kependudukan-content .kk-table th,
        .kependudukan-content .mutation-table th,
        .kependudukan-content .info-table th,
        .kependudukan-content .data-table th {
            padding: 16px 12px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
        }

        .kependudukan-content .resident-table td,
        .kependudukan-content .religion-table td,
        .kependudukan-content .area-table td,
        .kependudukan-content .kk-table td,
        .kependudukan-content .mutation-table td,
        .kependudukan-content .info-table td,
        .kependudukan-content .data-table td {
            padding: 16px 12px !important;
            font-size: 14px !important;
        }

        .kependudukan-content .action-link {
            font-size: 14px !important;
        }

        .kependudukan-content .action-cell {
            gap: 12px !important;
        }

        .kependudukan-content .table-footer {
            padding: 16px 12px !important;
            font-size: 14px !important;
        }

        .kependudukan-content .status-pill,
        .kependudukan-content .status-badge {
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 4px 12px !important;
        }

        .kependudukan-content .metrics-grid {
            gap: 16px !important;
            margin-bottom: 16px !important;
        }

        .kependudukan-content .metric-card {
            min-height: auto !important;
            padding: 20px !important;
        }

        .kependudukan-content .metric-label {
            font-size: 11px !important;
            margin-bottom: 6px !important;
        }

        .kependudukan-content .metric-value {
            font-size: 28px !important;
        }

        .kependudukan-content .panel-grid {
            gap: 16px !important;
            margin-top: 24px !important;
        }

        .kependudukan-content .panel-card,
        .kependudukan-content .form-card {
            padding: 24px !important;
        }

        .kependudukan-content .panel-title {
            font-size: 14px !important;
            margin-bottom: 20px !important;
        }

        .kependudukan-content .bar-label,
        .kependudukan-content .form-group label,
        .kependudukan-content .detail-label,
        .kependudukan-content .history p {
            font-size: 14px !important;
        }

        .kependudukan-content .detail-card {
            padding: 32px !important;
        }

        .kependudukan-content .detail-value {
            font-size: 16px !important;
        }

        .kependudukan-content .profile-container {
            padding-top: 24px !important;
        }

        .kependudukan-content .profile-title {
            margin-bottom: 24px !important;
        }

        .kependudukan-content .profile-card {
            max-width: 560px !important;
            min-height: 0 !important;
            padding: 32px 48px !important;
        }

        .kependudukan-content .profile-avatar-large {
            width: 96px !important;
            height: 96px !important;
            margin-bottom: 24px !important;
        }

        .kependudukan-content .profile-avatar-large svg {
            width: 54px !important;
            height: 54px !important;
        }

        .kependudukan-content .profile-name-large {
            font-size: 24px !important;
        }

        .kependudukan-content .profile-subtitle {
            font-size: 14px !important;
            margin-bottom: 24px !important;
        }
    </style>
    @stack('scripts')
</body>
</html>
