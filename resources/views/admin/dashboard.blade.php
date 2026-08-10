@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-subtitle">Ringkasan sistem dan manajemen akses pengguna.</p>
    </div>

    <div class="stats-grid">
        <div class="admin-card stat-card">
            <div class="stat-info">
                <h3>Total Pengguna</h3>
                <p>{{ $totalUsers }}</p>
            </div>
            <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
                <i class="fa-solid fa-user-group" style="font-size: 20px;"></i>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-info">
                <h3>Pengguna Aktif</h3>
                <p>{{ $activeUsers }}</p>
            </div>
            <div class="stat-icon" style="background: #ecfdf5; color: #10b981;">
                <i class="fa-regular fa-circle-user" style="font-size: 22px;"></i>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-info">
                <h3>Total Divisi</h3>
                <p>{{ $totalDivisions }}</p>
            </div>
            <div class="stat-icon" style="background: #f5f3ff; color: #8b5cf6;">
                <i class="fa-solid fa-building" style="font-size: 20px;"></i>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-info">
                <h3>Akses Nonaktif</h3>
                <p>{{ $inactiveAccess }}</p>
            </div>
            <div class="stat-icon" style="background: #fffbeb; color: #f59e0b;">
                <i class="fa-solid fa-shield-halved" style="font-size: 20px;"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Aktivitas Terbaru -->
        <div class="admin-card">
            <h3 style="margin-top: 0; color: var(--admin-text-main);">Aktivitas Terbaru</h3>
            
            @if($recentActivities->count() > 0)
                <div class="activity-list" style="margin-top: 20px;">
                    @foreach($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div class="activity-content">
                            <p style="color: var(--admin-text-main);"><span style="font-weight: 600;">{{ $activity->user->name ?? 'Sistem' }}</span> {{ $activity->description }}</p>
                            <small style="color: #9ca3af; margin-top: 4px; display: block;">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p style="color: var(--admin-text-muted);">Belum ada aktivitas.</p>
            @endif
        </div>

        <!-- Aksi Cepat -->
        <div class="admin-card">
            <h3 style="margin-top: 0; color: var(--admin-text-main);">Aksi Cepat</h3>
            <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 20px;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="justify-content: flex-start; text-decoration: none; padding: 12px 16px;">
                    <i class="fa-solid fa-plus" style="width: 24px; color: var(--admin-text-muted);"></i> Tambah Pengguna
                </a>
                <a href="#" class="btn btn-outline" style="justify-content: flex-start; text-decoration: none; padding: 12px 16px;" onclick="openModal('modalEditRole'); return false;">
                    <i class="fa-regular fa-circle-check" style="width: 24px; color: var(--admin-text-muted);"></i> Kelola Hak Akses
                </a>
                <a href="#" class="btn btn-outline" style="justify-content: flex-start; text-decoration: none; padding: 12px 16px;" onclick="openModal('modalEditDivision'); return false;">
                    <i class="fa-solid fa-building" style="width: 24px; color: var(--admin-text-muted);"></i> Kelola Divisi
                </a>
            </div>
        </div>
    </div>
@endsection
