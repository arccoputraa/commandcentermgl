<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Command Center Magelang Divisi Keuangan')</title>
    <link rel="icon" href="{{ asset('images/cmdcenterlogo.png') }}" type="image/png">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Keep Tailwind just in case inner views use it -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('images/cmdcenterlogo.png') }}" alt="Logo Command Center" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            </div>
            <h2>MagelangCC</h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('finance.dashboard') }}" class="menu-item {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard Keuangan
            </a>
            <a href="{{ route('finance.budget.index') }}" class="menu-item {{ request()->routeIs('finance.budget.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet"></i> Data Anggaran & Realisasi
            </a>
            <a href="{{ route('finance.pad.index') }}" class="menu-item {{ request()->routeIs('finance.pad.*') ? 'active' : '' }}">
                <i class="fa-solid fa-coins"></i> Pendapatan Daerah / PAD
            </a>
            <a href="{{ route('finance.tax.index') }}" class="menu-item {{ request()->routeIs('finance.tax.*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i> Data Pajak Daerah
            </a>
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
        </nav>
        <div class="sidebar-menu" style="flex-grow: 0; padding-top: 0;">
           <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
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
                    <h4>{{ Auth::user()->name ?? 'Divisi Keuangan' }}</h4>
                    <p>{{ Auth::user()->role ?? 'Administrator' }}</p>
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

    @stack('scripts')
</body>
</html>
