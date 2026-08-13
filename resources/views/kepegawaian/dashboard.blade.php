@extends('layouts.kepegawaian')

@section('title', 'Dashboard Kepegawaian')

@section('content')
<style>
    /* Custom CSS for Kepegawaian Dashboard */
    .kepegawaian-header {
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .kepegawaian-header h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    .kepegawaian-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .toolbar-container {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        background: #ffffff;
        padding: 8px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        font-family: 'Inter', sans-serif;
    }
    .search-input-wrapper {
        flex-grow: 1;
        position: relative;
        display: flex;
        align-items: center;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        color: #94a3b8;
    }
    .search-input-wrapper input {
        width: 100%;
        padding: 10px 16px 10px 44px;
        border-radius: 8px;
        background: transparent;
        border: none;
        outline: none;
        font-size: 14px;
        color: #334155;
    }
    .toolbar-divider {
        width: 1px;
        height: 32px;
        background: #e2e8f0;
    }
    .btn-filter {
        background: #2563eb;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-right: 4px;
    }
    .btn-filter:hover {
        background: #1d4ed8;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 16px;
        font-family: 'Inter', sans-serif;
    }
    .metric-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .metric-card.alt-bg {
        background: #f8fafc;
        box-shadow: none;
    }
    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .metric-icon.blue { background: #eff6ff; color: #3b82f6; }
    .metric-icon.green { background: #f0fdf4; color: #10b981; }
    .metric-icon.orange { background: #fff7ed; color: #f97316; }
    .metric-icon.purple { background: #faf5ff; color: #a855f7; }
    
    .metric-content {
        flex-grow: 1;
    }
    .metric-label {
        font-size: 13.5px;
        color: #64748b;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .metric-value {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
    }
    
    .list-section {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        font-family: 'Inter', sans-serif;
        padding: 24px;
        margin-top: 24px;
    }
    .list-header {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .list-header a {
        font-size: 13px;
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }
    
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .info-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        transition: background 0.2s;
    }
    .info-item:hover {
        background: #f8fafc;
    }
    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }
    .info-content {
        flex-grow: 1;
    }
    .info-title {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
        margin-bottom: 4px;
    }
    .info-meta {
        font-size: 12px;
        color: #64748b;
    }
    .badge-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        background: #dcfce7;
        color: #166534;
    }
</style>

<!-- Header -->
<div class="kepegawaian-header">
    <h2>Dashboard Kepegawaian</h2>
    <p>Ringkasan informasi data pegawai, mutasi, dan informasi kepegawaian terkini.</p>
</div>

<!-- Metrics Grid 4x2 -->
<div class="metrics-grid">
    <!-- Card 1: Total Pegawai -->
    <div class="metric-card">
        <div class="metric-icon blue" style="background:#eff6ff; color:#3b82f6;"><i class="fa-solid fa-users"></i></div>
        <div class="metric-content">
            <p class="metric-value">{{ $totalPegawai }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">TOTAL PEGAWAI</p>
        </div>
    </div>
    <!-- Card 2: Pegawai Aktif -->
    <div class="metric-card">
        <div class="metric-icon green" style="background:#f0fdf4; color:#10b981;"><i class="fa-regular fa-circle-check"></i></div>
        <div class="metric-content">
            <p class="metric-value">{{ $pegawaiAktif }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">PEGAWAI AKTIF</p>
        </div>
    </div>
    <!-- Card 3: PNS -->
    <div class="metric-card">
        <div class="metric-icon blue" style="background:#eff6ff; color:#3b82f6;"><i class="fa-regular fa-id-badge"></i></div>
        <div class="metric-content">
            <p class="metric-value">{{ $pnsCount }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">PNS</p>
        </div>
    </div>
    <!-- Card 4: PPPK -->
    <div class="metric-card">
        <div class="metric-icon purple" style="background:#faf5ff; color:#a855f7;"><i class="fa-regular fa-id-card"></i></div>
        <div class="metric-content">
            <p class="metric-value">{{ $pppkCount }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">PPPK</p>
        </div>
    </div>
    
    <!-- Card 5: Non-ASN -->
    <div class="metric-card">
        <div class="metric-icon orange" style="background:#fff7ed; color:#f97316;"><i class="fa-solid fa-user-tie"></i></div>
        <div class="metric-content">
            <p class="metric-value">{{ $nonAsnCount }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">NON-ASN</p>
        </div>
    </div>
    <!-- Card 6: Mendekati Pensiun -->
    <div class="metric-card">
        <div class="metric-icon red" style="background:#fef2f2; color:#ef4444;"><i class="fa-solid fa-heart-pulse"></i></div>
        <div class="metric-content">
            <p class="metric-value">{{ $mendekatiPensiun }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">MENDEKATI PENSIUN</p>
        </div>
    </div>
    <!-- Card 7: Mutasi Tahun Ini -->
    <div class="metric-card">
        <div class="metric-icon green" style="background:#f0fdf4; color:#10b981;"><i class="fa-solid fa-file-signature"></i></div>
        <div class="metric-content">
            <p class="metric-value">{{ $mutasiTahunIni }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">MUTASI TAHUN INI</p>
        </div>
    </div>
    <!-- Card 8: Update Terakhir -->
    <div class="metric-card">
        <div class="metric-icon gray" style="background:#f1f5f9; color:#64748b;"><i class="fa-regular fa-file-lines"></i></div>
        <div class="metric-content">
            <p class="metric-value" style="font-size:18px;">{{ date('d M Y') }}</p>
            <p class="metric-label" style="text-transform:uppercase; font-size:11px; font-weight:600; letter-spacing:0.5px;">UPDATE TERAKHIR</p>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:24px;">
    
    <!-- Chart 1: Pegawai Per Unit Kerja -->
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
        <h3 style="margin:0 0 20px 0; font-size:14px; font-weight:700; color:#0f172a; text-transform:uppercase; letter-spacing:0.5px;">PEGAWAI PER UNIT KERJA</h3>
        <div style="display:flex; flex-direction:column; gap:16px;">
            @foreach($pegawaiPerUnit as $unit)
            @php $percent = ($unit->total / $maxPerUnit) * 100; @endphp
            <div>
                <div style="display:flex; justify-content:space-between; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">
                    <span>{{ $unit->unit_kerja }}</span>
                    <span>{{ $unit->total }}</span>
                </div>
                <div style="width:100%; height:8px; background:#f1f5f9; border-radius:4px; overflow:hidden;">
                    <div style="width:{{ $percent }}%; height:100%; background:#6366f1; border-radius:4px;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Chart 2: Komposisi Status Pegawai -->
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
        <h3 style="margin:0 0 20px 0; font-size:14px; font-weight:700; color:#0f172a; text-transform:uppercase; letter-spacing:0.5px;">KOMPOSISI STATUS PEGAWAI</h3>
        <div style="display:flex; flex-direction:column; gap:20px;">
            
            @php 
                $pnsPct = $totalPegawai > 0 ? round(($pnsCount / $totalPegawai) * 100) : 0;
                $pppkPct = $totalPegawai > 0 ? round(($pppkCount / $totalPegawai) * 100) : 0;
                $nonAsnPct = $totalPegawai > 0 ? round(($nonAsnCount / $totalPegawai) * 100) : 0;
            @endphp
            
            <!-- PNS -->
            <div>
                <div style="display:flex; justify-content:space-between; font-size:13px; color:#334155; margin-bottom:8px;">
                    <span style="font-weight:600;">PNS</span>
                    <span><span style="color:#64748b;">{{ $pnsCount }} pegawai</span> <strong style="color:#0f172a;">({{ $pnsPct }}%)</strong></span>
                </div>
                <div style="width:100%; height:10px; background:#f1f5f9; border-radius:5px; overflow:hidden;">
                    <div style="width:{{ $pnsPct }}%; height:100%; background:#3b82f6; border-radius:5px;"></div>
                </div>
            </div>
            
            <!-- PPPK -->
            <div>
                <div style="display:flex; justify-content:space-between; font-size:13px; color:#334155; margin-bottom:8px;">
                    <span style="font-weight:600;">PPPK</span>
                    <span><span style="color:#64748b;">{{ $pppkCount }} pegawai</span> <strong style="color:#0f172a;">({{ $pppkPct }}%)</strong></span>
                </div>
                <div style="width:100%; height:10px; background:#f1f5f9; border-radius:5px; overflow:hidden;">
                    <div style="width:{{ $pppkPct }}%; height:100%; background:#a855f7; border-radius:5px;"></div>
                </div>
            </div>
            
            <!-- Non-ASN -->
            <div>
                <div style="display:flex; justify-content:space-between; font-size:13px; color:#334155; margin-bottom:8px;">
                    <span style="font-weight:600;">Non-ASN</span>
                    <span><span style="color:#64748b;">{{ $nonAsnCount }} pegawai</span> <strong style="color:#0f172a;">({{ $nonAsnPct }}%)</strong></span>
                </div>
                <div style="width:100%; height:10px; background:#f1f5f9; border-radius:5px; overflow:hidden;">
                    <div style="width:{{ $nonAsnPct }}%; height:100%; background:#f59e0b; border-radius:5px;"></div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
