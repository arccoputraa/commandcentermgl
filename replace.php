<?php
$dir = __DIR__ . '/resources/views/layouts/';
$files = ['finance.blade.php', 'kepegawaian.blade.php', 'kependudukan.blade.php', 'kesehatan.blade.php', 'pembangunan.blade.php', 'perhubungan.blade.php', 'perizinan.blade.php', 'sig.blade.php'];
foreach ($files as $file) {
    $path = $dir . $file;
    if(!file_exists($path)) continue;
    $content = file_get_contents($path);
    $division = str_replace('.blade.php', '', $file);

    // Add Manajemen User Divisi to sidebar just before Profil
    $menuItem = "
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isDivisionAdmin())
            <a href=\"{{ route('division.users.index', '{$division}') }}\" class=\"menu-item {{ request()->routeIs('division.users.*') ? 'active' : '' }}\">
                <i class=\"fa-solid fa-users-gear\"></i> Manajemen User
            </a>
            @endif
            <a href=\"{{ route('profile";
            
    $content = str_replace('<a href="{{ route(\'profile', $menuItem, $content);

    // Add Kembali ke Global Admin in topbar
    $topbarAdd = "
            @if(Auth::user()->isSuperAdmin())
            <a href=\"{{ route('admin.dashboard') }}\" style=\"margin-right: 15px; background: #f1f5f9; padding: 6px 12px; border-radius: 6px; font-size: 13px; color: #333; text-decoration: none;\"><i class=\"fa-solid fa-arrow-left\"></i> Global Admin</a>
            @endif
            <div class=\"profile-info\">";
            
    $content = str_replace('<div class="profile-info">', $topbarAdd, $content);

    file_put_contents($path, $content);
    echo "Updated $file\n";
}
