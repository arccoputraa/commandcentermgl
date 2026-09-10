@extends('layouts.kesehatan')

@section('title', 'Dashboard Kesehatan')

@push('styles')
<style>
    .dashboard-header { margin-bottom: 24px; }
    .dashboard-header h1 { font-size: 24px; font-weight: 700; color: #1E293B; margin-bottom: 6px; }
    .dashboard-header p { color: #64748B; font-size: 14px; }

    .filter-card {
        background: #ffffff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .filter-inputs-group {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        flex: 1;
    }
    .filter-input-slot {
        height: 40px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        background: #fff;
        padding: 0 14px;
        font-size: 13px;
        color: #334155;
        outline: none;
        width: 100%;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .filter-input-slot:focus {
        border-color: #059669;
    }
    .btn-apply-filter {
        background: #059669;
        color: #ffffff;
        border: none;
        height: 40px;
        padding: 0 24px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s;
    }
    .btn-apply-filter:hover { background: #047857; }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }
    .metric-card {
        background: #ffffff;
        border: 1px solid #F1F5F9;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .metric-title {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .metric-value {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        line-height: 1.2;
    }
    .metric-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-blue-light { background: #EFF6FF; color: #2563EB; }
    .icon-emerald-light { background: #ECFDF5; color: #10B981; }
    .icon-rose-light { background: #FFF1F2; color: #F43F5E; }
    .icon-purple-light { background: #F3E8FF; color: #9333EA; }
    .icon-indigo-light { background: #EEF2FF; color: #6366F1; }
    .icon-amber-light { background: #FFFBEB; color: #D97706; }
    .icon-teal-light { background: #F0FDFA; color: #0D9488; }
    .icon-slate-light { background: #F8FAFC; color: #475569; }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 16px;
    }

    .program-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .program-card {
        background: #ffffff;
        border: 1px solid #F1F5F9;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .program-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .program-name {
        font-size: 15px;
        font-weight: 700;
        color: #1E293B;
        line-height: 1.3;
        max-width: 140px;
    }
    .badge-status {
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-aktif { background: #DCFCE7; color: #166534; }
    .badge-selesai { background: #F1F5F9; color: #475569; }

    .program-val {
        font-size: 22px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 16px;
    }

    .progress-container { margin-bottom: 16px; }
    .progress-track {
        height: 6px;
        background: #F1F5F9;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 6px;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
    }
    .progress-labels {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: #64748B;
    }

    .btn-detail-link {
        display: block;
        width: 100%;
        text-align: center;
        padding: 8px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        color: #2563EB;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-detail-link:hover { background: #F8FAFC; }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1>Dashboard Kesehatan</h1>
    <p>Pantau program kesehatan, tren pasien, penyakit terbanyak, dan sebaran kasus masyarakat.</p>
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('kesehatan.dashboard') }}" class="filter-card">
    <div class="filter-inputs-group">
        <select name="tahun" class="filter-input-slot">
            <option value="">Semua Tahun</option>
            <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>Tahun 2026</option>
            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>Tahun 2025</option>
            <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>Tahun 2024</option>
        </select>
        <select name="faskes" class="filter-input-slot">
            <option value="">Semua Faskes</option>
            <option value="rsud_tidar" {{ request('faskes') == 'rsud_tidar' ? 'selected' : '' }}>RSUD Tidar</option>
            <option value="puskesmas_utara" {{ request('faskes') == 'puskesmas_utara' ? 'selected' : '' }}>Puskesmas Magelang Utara</option>
            <option value="puskesmas_tengah" {{ request('faskes') == 'puskesmas_tengah' ? 'selected' : '' }}>Puskesmas Magelang Tengah</option>
            <option value="puskesmas_selatan" {{ request('faskes') == 'puskesmas_selatan' ? 'selected' : '' }}>Puskesmas Magelang Selatan</option>
        </select>
        <select name="wilayah" class="filter-input-slot">
            <option value="">Semua Wilayah</option>
            <option value="Magelang Utara" {{ request('wilayah') == 'Magelang Utara' ? 'selected' : '' }}>Magelang Utara</option>
            <option value="Magelang Tengah" {{ request('wilayah') == 'Magelang Tengah' ? 'selected' : '' }}>Magelang Tengah</option>
            <option value="Magelang Selatan" {{ request('wilayah') == 'Magelang Selatan' ? 'selected' : '' }}>Magelang Selatan</option>
        </select>
        <input type="text" name="keyword" class="filter-input-slot" placeholder="Cari program / kasus..." value="{{ request('keyword') }}">
    </div>
    <button type="submit" class="btn-apply-filter">Terapkan Filter</button>
</form>

<!-- Metrics Cards (Row 1 & 2 -> 4 Columns) -->
<div class="metrics-grid">
    <!-- Card 1 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Total Program</div>
            <div class="metric-value">{{ number_format($totalProgram) }}</div>
        </div>
        <div class="metric-icon-box icon-blue-light">
            <i class="fa-regular fa-file-lines"></i>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Pasien Terpantau</div>
            <div class="metric-value">{{ number_format($pasienTerpantau) }}</div>
        </div>
        <div class="metric-icon-box icon-emerald-light">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Kasus Aktif</div>
            <div class="metric-value">{{ number_format($kasusAktif) }}</div>
        </div>
        <div class="metric-icon-box icon-rose-light">
            <i class="fa-solid fa-heart-pulse"></i>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Imunisasi</div>
            <div class="metric-value">{{ number_format($imunisasi) }}</div>
        </div>
        <div class="metric-icon-box icon-purple-light">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
    </div>

    <!-- Card 5 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Vaksinasi</div>
            <div class="metric-value">{{ number_format($vaksinasi) }}</div>
        </div>
        <div class="metric-icon-box icon-indigo-light">
            <i class="fa-regular fa-circle-check"></i>
        </div>
    </div>

    <!-- Card 6 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Pencegahan Stunting</div>
            <div class="metric-value">{{ number_format($pencegahanStunting) }}</div>
        </div>
        <div class="metric-icon-box icon-amber-light">
            <i class="fa-solid fa-user-group"></i>
        </div>
    </div>

    <!-- Card 7 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Kartu Sehat</div>
            <div class="metric-value">{{ number_format($kartuSehat) }}</div>
        </div>
        <div class="metric-icon-box icon-teal-light">
            <i class="fa-regular fa-hospital"></i>
        </div>
    </div>

    <!-- Card 8 -->
    <div class="metric-card">
        <div>
            <div class="metric-title">Update Terakhir</div>
            <div class="metric-value">{{ $updateTerakhir }}</div>
        </div>
        <div class="metric-icon-box icon-slate-light">
            <i class="fa-regular fa-pen-to-square"></i>
        </div>
    </div>
</div>

<!-- Program Kesehatan Utama Section -->
<h2 class="section-title">Program Kesehatan Utama</h2>

<div class="program-grid">
    @foreach($programUtama as $prog)
    <div class="program-card">
        <div>
            <div class="program-header">
                <span class="program-name">{{ $prog['judul'] }}</span>
                <span class="badge-status {{ $prog['status'] == 'Aktif' ? 'badge-aktif' : 'badge-selesai' }}">
                    {{ $prog['status'] }}
                </span>
            </div>
            <div class="program-val">{{ $prog['jumlah'] }}</div>
        </div>

        <div>
            <div class="progress-container">
                <div class="progress-track">
                    <div class="progress-bar-fill" style="width: {{ $prog['persentase'] }}%; background-color: {{ $prog['bar_color'] }};"></div>
                </div>
                <div class="progress-labels">
                    <span>Progress Capaian</span>
                    <span style="font-weight: 700; color: #334155;">{{ $prog['persentase'] }}%</span>
                </div>
            </div>

            <a href="{{ $prog['route'] }}" class="btn-detail-link">Lihat Detail</a>
        </div>
    </div>
    @endforeach
</div>

@include('components.login-log-widget')
@endsection


