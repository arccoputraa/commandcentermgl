@extends('layouts.admin')

@section('content')
    <h1 class="page-title">Dashboard Admin</h1>

    <div class="stats-grid">
        <div class="admin-card stat-card">
            <div class="stat-icon primary">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Pengguna</h3>
                <p>{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-icon success">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3>Pengguna Aktif</h3>
                <p>{{ $activeUsers }}</p>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-icon warning">
                <i class="fa-solid fa-building"></i>
            </div>
            <div class="stat-info">
                <h3>Total Divisi</h3>
                <p>{{ $totalDivisions }}</p>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-icon danger">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <div class="stat-info">
                <h3>Akses Nonaktif</h3>
                <p>{{ $inactiveAccess }}</p>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Aktivitas Terbaru -->
        <div class="admin-card">
            <h3 style="margin-top: 0; color: var(--admin-text-main);">Aktivitas Terbaru</h3>
            
            @if($recentActivities->count() > 0)
                <div class="activity-list">
                    @foreach($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div class="activity-content">
                            <p><strong>{{ $activity->user->name ?? 'Sistem' }}</strong> {{ $activity->description }}</p>
                            <small>{{ $activity->created_at->diffForHumans() }}</small>
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
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-user-plus"></i> Tambah Pengguna
                </a>
                <a href="#" class="btn btn-outline" style="text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-shield-halved"></i> Kelola Hak Akses
                </a>
                <a href="#" class="btn btn-outline" style="text-align: center; text-decoration: none;">
                    <i class="fa-solid fa-building"></i> Kelola Divisi
                </a>
            </div>
        </div>
    </div>
@endsection
