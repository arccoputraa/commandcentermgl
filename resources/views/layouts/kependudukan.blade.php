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
    <style>
        body { background:#ffffff; }
        .admin-sidebar { width:300px; background:#0d1b2e !important; box-shadow:none; }
        .admin-main { margin-left:300px; background:#ffffff; }
        .sidebar-header { height:74px; padding:0 28px; gap:14px; border-bottom:1px solid rgba(255,255,255,.06); }
        .sidebar-header .logo-container { width:38px; height:38px; border-radius:7px; padding:0; }
        .sidebar-header img { width:30px; height:30px; }
        .sidebar-header h2 { font-size:22px; }
        .sidebar-menu { padding:28px 18px; gap:12px; }
        .menu-item { min-height:48px; padding:12px 18px; border-radius:11px; font-size:18px; line-height:1.25; gap:16px; color:#c7d1df; }
        .menu-item.active { background:#334157; color:#fff; }
        .menu-item i { width:24px; font-size:18px; }
        .menu-item.active::before { left:16px; width:7px; height:7px; }
        .menu-item.active i { margin-left:18px; color:#22d3ee; }
        .admin-topbar { height:74px; padding:0 36px; background:#fff; }
        .topbar-title { font-size:22px; color:#1d293d; }
        .profile-info h4 { font-size:17px; }
        .profile-info p { font-size:15px; color:#708098; }
        .profile-img { width:42px; height:42px; font-size:19px; }
        .admin-content { padding:44px 48px; }
    </style>
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

        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
