@extends('layouts.admin')

@section('content')
<style>
    .detail-container {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 24px;
        margin-top: 24px;
        font-family: 'Inter', sans-serif;
    }
    .profile-card, .activity-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        padding: 32px;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 32px;
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border: 4px solid #f8fafc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: #64748b;
        font-size: 32px;
        box-shadow: 0 0 0 1px #e2e8f0;
    }
    .profile-name {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    .profile-nip {
        font-size: 14px;
        color: #64748b;
        margin: 0 0 16px 0;
    }
    .status-badge {
        display: inline-block;
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .status-badge.nonaktif {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
    }
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        border-bottom: 1px dashed #f1f5f9;
        padding-bottom: 8px;
    }
    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .info-label {
        color: #64748b;
    }
    .info-value {
        font-weight: 600;
        color: #334155;
        text-align: right;
    }
    .btn-edit {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        width: 100%;
        background: #2563eb;
        color: #ffffff;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-edit:hover {
        background: #1d4ed8;
    }
    
    .activity-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 32px 0;
    }
    .timeline {
        position: relative;
        max-width: 100%;
        margin: 0 auto;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
    .timeline-item.left {
        flex-direction: row-reverse;
    }
    .timeline-icon {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        font-size: 16px;
        box-shadow: 0 0 0 6px #ffffff;
    }
    .timeline-content {
        width: 42%;
        background: #ffffff;
        padding: 16px 20px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .timeline-spacer {
        width: 42%;
    }
    .timeline-item.left .timeline-content {
        text-align: right;
    }
    .activity-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }
    .timeline-item.left .activity-head {
        flex-direction: row-reverse;
    }
    .activity-name {
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
    }
    .activity-time {
        font-size: 12px;
        color: #94a3b8;
    }
    .activity-desc {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* Custom Header */
    .page-header-custom {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 8px;
    }
    .page-header-custom a {
        color: #64748b;
        font-size: 20px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        transition: background 0.2s;
    }
    .page-header-custom a:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .page-header-custom h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        font-family: 'Inter', sans-serif;
    }
</style>

<div class="page-header-custom">
    <a href="{{ route('admin.users.index') }}"><i class="fa-solid fa-angle-left"></i></a>
    <h1>Detail Pengguna</h1>
</div>

<div class="detail-container">
    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fa-regular fa-user"></i>
            </div>
            <h2 class="profile-name">{{ $user->name }}</h2>
            <p class="profile-nip">{{ $user->nip ?? $user->email }}</p>
            <span class="status-badge {{ $user->status == 'nonaktif' ? 'nonaktif' : '' }}">
                {{ ucfirst($user->status) }}
            </span>
        </div>

        <div class="info-list">
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Divisi</span>
                <span class="info-value">{{ $user->division ? $user->division->name : '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Role</span>
                <span class="info-value">{{ ucfirst($user->role) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Dibuat Pada</span>
                <span class="info-value">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
            </div>
        </div>

        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">
            <i class="fa-regular fa-pen-to-square"></i> Edit Pengguna
        </a>
    </div>

    <!-- Activity Card -->
    <div class="activity-card">
        <h2 class="activity-title">Riwayat Aktivitas</h2>
        
        <div class="timeline">
            @forelse($activities as $index => $activity)
                <div class="timeline-item {{ $index % 2 == 0 ? 'right' : 'left' }}">
                    <div class="timeline-spacer"></div>
                    <div class="timeline-icon">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="activity-head">
                            <span class="activity-name">Login Sistem</span>
                            <span class="activity-time">{{ $activity->created_at->format('h:i A') }}</span>
                        </div>
                        <p class="activity-desc">{{ $activity->description ?? 'Berhasil login ke Dashboard' }}</p>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #94a3b8; font-size: 14px;">Belum ada aktivitas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
