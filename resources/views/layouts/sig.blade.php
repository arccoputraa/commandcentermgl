<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard SIG') - Command Center Magelang</title>
<link rel="icon" href="{{ asset('images/cmdcenterlogo.png') }}" type="image/png">
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
                <img src="{{ asset('images/cmdcenterlogo.png') }}" alt="Logo Command Center" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            </div>
            <h2>MagelangCC</h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('sig.dashboard') }}" class="menu-item {{ request()->routeIs('sig.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard SIG
            </a>
            <a href="{{ route('sig.layer.index') }}" class="menu-item {{ request()->routeIs('sig.layer.*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> Manajemen Layer
            </a>
            <a href="{{ route('sig.data-spasial.index') }}" class="menu-item {{ request()->routeIs('sig.data-spasial.*') ? 'active' : '' }}">
                <i class="fa-solid fa-map-location-dot"></i> Data Spasial
            </a>
            <a href="{{ route('sig.dokumen.index') }}" class="menu-item {{ request()->routeIs('sig.dokumen.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pdf"></i> Dokumen SIG
            </a>
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
        </nav>
        <div class="sidebar-menu" style="flex-grow: 0; padding-top: 0;">
           <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                    <h4>{{ Auth::user()->name ?? 'User SIG' }}</h4>
                    <p>Divisi SIG</p>
                </div>
                <div class="profile-img">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success" style="padding: 1rem; margin-bottom: 1rem; border-radius: 4px; background-color: #d1fae5; color: #065f46;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="padding: 1rem; margin-bottom: 1rem; border-radius: 4px; background-color: #fee2e2; color: #991b1b;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
