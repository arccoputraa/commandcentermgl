<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Keuangan') - Command Center Magelang</title>
<link rel="icon" href="{{ asset('images/cmdcenterlogo.png') }}" type="image/png">
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
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('img/logo-mgl.png') }}" alt="Logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            </div>
            <h2>MagelangCC</h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('finance.dashboard') }}" class="menu-item {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> Dashboard Keuangan
            </a>
            <a href="{{ route('finance.budget.index') }}" class="menu-item {{ request()->routeIs('finance.budget.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet"></i> Data Anggaran & Realisasi
            </a>
            <a href="{{ route('finance.pad.index') }}" class="menu-item {{ request()->routeIs('finance.pad.*') ? 'active' : '' }}">
                <i class="fa-solid fa-suitcase"></i> Pendapatan Daerah / PAD
            </a>
            <a href="{{ route('finance.tax.index') }}" class="menu-item {{ request()->routeIs('finance.tax.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i> Data Pajak Daerah
            </a>
            <a href="{{ route('finance.subbidang.index') }}" class="menu-item {{ request()->routeIs('finance.subbidang.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Sub Bidang / Unit Keuangan
            </a>
            <a href="{{ route('finance.information.index') }}" class="menu-item {{ request()->routeIs('finance.information.*') ? 'active' : '' }}">
                <i class="fa-solid fa-download"></i> Informasi Terbaru
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
                    <h4>{{ Auth::user()->name ?? 'User Keuangan' }}</h4>
                    <p>{{ Auth::user()->division->name ?? 'Divisi Keuangan' }}</p>
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

