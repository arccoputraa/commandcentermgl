<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Command Center Magelang</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('img/logo-mgl.png') }}" alt="Logo Kota Magelang" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            <h2>Command Center<br><small>Kota Magelang</small></h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Daftar Pengguna
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-shield-halved"></i> Hak Akses
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-building"></i> Daftar Divisi
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-video"></i> CCTV
            </a>
        </nav>
        <div class="sidebar-menu" style="flex-grow: 0; padding-top: 0;">
            <a href="#" class="menu-item">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
            <a href="#" class="menu-item" style="color: var(--admin-danger);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-sign-out-alt"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="topbar-search">
                <i class="fa-solid fa-search" style="color: var(--admin-text-muted);"></i>
                <input type="text" placeholder="Cari data...">
            </div>
            <div class="topbar-profile">
                <div class="profile-info">
                    <h4>{{ Auth::user()->name ?? 'Administrator' }}</h4>
                    <p>{{ Auth::user()->role ?? 'Admin' }}</p>
                </div>
                <div class="profile-img">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
