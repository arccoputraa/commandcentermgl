<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Perizinan') - Command Center Magelang</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('img/logo-mgl.png') }}" alt="Logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            </div>
            <h2>MagelangCC</h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('perizinan.dashboard') }}" class="menu-item {{ request()->routeIs('perizinan.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard Perizinan
            </a>
            <a href="{{ route('perizinan.data.index') }}" class="menu-item {{ request()->routeIs('perizinan.data.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i> Daftar Data Perizinan
            </a>
            <a href="{{ route('perizinan.jenis.index') }}" class="menu-item {{ request()->routeIs('perizinan.jenis.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Jenis Izin & SLA
            </a>
            <a href="{{ route('perizinan.publikasi.index') }}" class="menu-item {{ request()->routeIs('perizinan.publikasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> Publikasi Masyarakat
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
            <div class="topbar-left">
                <h2 class="topbar-title">Command Center</h2>
            </div>
            <div class="topbar-profile">
                <div class="profile-info">
                    <h4>{{ Auth::user()->name ?? 'User Perizinan' }}</h4>
                    <p>{{ Auth::user()->division->name ?? 'Divisi Perizinan' }}</p>
                </div>
                <div class="profile-img">
                    <i class="fa-regular fa-user"></i>
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
