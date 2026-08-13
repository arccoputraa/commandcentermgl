<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Kepegawaian') - Command Center Magelang</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar" style="background-color: #0f172a;">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('img/logo-mgl.png') }}" alt="Logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            </div>
            <h2>MagelangCC</h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('kepegawaian.dashboard') }}" class="menu-item {{ request()->routeIs('kepegawaian.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> Dashboard Kepegawaian
            </a>
            <a href="{{ route('kepegawaian.data.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.data.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Data Pegawai
            </a>
            <a href="{{ route('kepegawaian.jabatan.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.jabatan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building-user"></i> Jabatan & Unit Kerja
            </a>
            <a href="{{ route('kepegawaian.mutasi.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.mutasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-people-arrows"></i> Mutasi & Pensiun
            </a>
            <a href="{{ route('kepegawaian.informasi.index') }}" class="menu-item {{ request()->routeIs('kepegawaian.informasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i> Informasi Terbaru
            </a>
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-regular fa-circle-user"></i> Profil
            </a>
        </nav>
        <div class="sidebar-menu" style="flex-grow: 0; padding-top: 0;">
            <a href="#" class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
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
                    <h4>{{ Auth::user()->name ?? 'Admin Kepegawaian' }}</h4>
                    <p>{{ Auth::user()->division->name ?? 'Divisi Kepegawaian' }}</p>
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
