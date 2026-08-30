@extends('layouts.sig')

@section('title', 'Dashboard SIG')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Dashboard SIG</h1>
        <p class="page-subtitle">Sistem Informasi Geografis & Pemetaan Wilayah Kota.</p>
    </div>

    <div class="stats-grid">
        <div class="admin-card stat-card">
            <div class="stat-info">
                <h3>Total Layer</h3>
                <p>{{ $stats['total_layer'] ?? 0 }}</p>
            </div>
            <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
                <i class="fa-solid fa-layer-group" style="font-size: 20px;"></i>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-info">
                <h3>Layer Aktif</h3>
                <p>{{ $stats['layer_aktif'] ?? 0 }}</p>
            </div>
            <div class="stat-icon" style="background: #ecfdf5; color: #10b981;">
                <i class="fa-solid fa-check" style="font-size: 22px;"></i>
            </div>
        </div>
        <div class="admin-card stat-card">
            <div class="stat-info">
                <h3>Total Data Spasial</h3>
                <p>{{ $stats['total_data'] ?? 0 }}</p>
            </div>
            <div class="stat-icon" style="background: #f5f3ff; color: #8b5cf6;">
                <i class="fa-solid fa-map-location-dot" style="font-size: 20px;"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="admin-card">
            <h3 style="margin-top: 0; color: var(--admin-text-main);">Dokumen SIG Terbaru</h3>
            
            @if($dokumen->count() > 0)
                <div class="activity-list" style="margin-top: 20px;">
                    @foreach($dokumen as $doc)
                    <div class="activity-item">
                        <div class="activity-icon" style="background: #fef2f2; color: #ef4444;">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div class="activity-content">
                            <p style="color: var(--admin-text-main);"><span style="font-weight: 600;">{{ $doc->judul }}</span></p>
                            <small style="color: #9ca3af; margin-top: 4px; display: block;">Rilis: {{ optional($doc->tanggal_rilis)->format('d M Y') ?? '-' }} - Tag: {{ $doc->status_tag }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p style="color: var(--admin-text-muted);">Belum ada dokumen yang diunggah.</p>
            @endif
        </div>

        <div class="admin-card">
            <h3 style="margin-top: 0; color: var(--admin-text-main);">Aksi Cepat</h3>
            <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 20px;">
                <a href="{{ route('sig.data-spasial.index') }}" class="btn btn-outline" style="justify-content: flex-start; text-decoration: none; padding: 12px 16px;">
                    <i class="fa-solid fa-plus" style="width: 24px; color: var(--admin-text-muted);"></i> Tambah Data Spasial
                </a>
                <a href="{{ route('sig.layer.index') }}" class="btn btn-outline" style="justify-content: flex-start; text-decoration: none; padding: 12px 16px;">
                    <i class="fa-solid fa-layer-group" style="width: 24px; color: var(--admin-text-muted);"></i> Kelola Layer
                </a>
            </div>
        </div>
    </div>
@endsection
