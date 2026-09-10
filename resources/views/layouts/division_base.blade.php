<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Divisi') - Command Center Magelang</title>
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
            @yield('sidebar_menu')
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
                <button class="mobile-toggle" onclick="document.querySelector('.admin-sidebar').classList.toggle('open')">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h2 class="topbar-title">Command Center</h2>
            </div>
            <div class="topbar-profile">
                @if(Auth::check() && Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}" style="margin-right: 15px; background: #f1f5f9; padding: 6px 12px; border-radius: 6px; font-size: 13px; color: #333; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-weight: 500;">
                    <i class="fa-solid fa-arrow-left"></i> Global Admin
                </a>
                @endif
                <div class="profile-info">
                    <h4>{{ Auth::user()->name ?? 'User Divisi' }}</h4>
                    <p>{{ Auth::user()->division?->name ?? 'Administrator Global' }}</p>
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
    <script>
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.admin-sidebar');
            const toggle  = document.querySelector('.mobile-toggle');

            // Tutup sidebar di mobile jika klik di luar
            if (window.innerWidth <= 991 && sidebar && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && toggle && !toggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    </script>
</body>
</html>
