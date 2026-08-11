@extends('layouts.kesehatan')

@section('title', 'Dashboard Kesehatan')

@push('styles')
<style>
    .dashboard-header {
        margin-bottom: 24px;
    }
    .dashboard-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
    }
    .dashboard-header p {
        color: #64748B;
        font-size: 14px;
    }
    .filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }
    .filter-input {
        padding: 10px 16px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 14px;
        color: #64748B;
        background: #fff;
        min-width: 200px;
        flex: 1;
    }
    .btn-primary-custom {
        background: #009966;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-primary-custom:hover {
        background: #008055;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .stat-label {
        font-size: 11px;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
    }
    .stat-icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    
    .icon-blue { background: #EFF6FF; color: #3B82F6; }
    .icon-green { background: #ECFDF5; color: #10B981; }
    .icon-red { background: #FEF2F2; color: #EF4444; }
    .icon-purple { background: #FAF5FF; color: #A855F7; }
    .icon-orange { background: #FFF7ED; color: #F97316; }
    .icon-teal { background: #F0FDFA; color: #14B8A6; }
    .icon-gray { background: #F8FAFC; color: #64748B; }
    
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 16px;
    }

    .program-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .program-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .program-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    .program-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #1E293B;
        max-width: 70%;
    }
    .program-value {
        font-size: 20px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 4px;
    }
    .program-subtitle {
        font-size: 12px;
        color: #64748B;
        margin-bottom: 16px;
    }
    .progress-container {
        margin-bottom: 16px;
    }
    .progress-header {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        color: #64748B;
        margin-bottom: 6px;
    }
    .progress-bar-bg {
        height: 6px;
        background: #F1F5F9;
        border-radius: 3px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        background: #3B82F6;
        border-radius: 3px;
    }
    .fill-green { background: #10B981; }
    .fill-orange { background: #F59E0B; }
    
    .btn-detail {
        display: block;
        width: 100%;
        text-align: center;
        padding: 8px;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        color: #3B82F6;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-detail:hover {
        background: #F8FAFC;
    }
    .badge-aktif {
        background: #ECFDF5;
        color: #10B981;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
    .badge-selesai {
        background: #F8FAFC;
        color: #64748B;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1>Dashboard Kesehatan</h1>
    <p>Pantau program kesehatan, tren pasien, penyakit terbanyak, dan sebaran kasus masyarakat.</p>
</div>

<div class="filter-bar">
    <input type="text" class="filter-input" placeholder="Cari data...">
    <input type="text" class="filter-input" placeholder="Semua Faskes">
    <input type="text" class="filter-input" placeholder="Semua Wilayah">
    <input type="date" class="filter-input" placeholder="Bulan">
    <button class="btn-primary-custom">Terapkan Filter</button>
</div>

<div class="stats-grid">
    <!-- Row 1 -->
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">TOTAL PROGRAM</span>
            <span class="stat-value">{{ number_format($totalProgram) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-blue"><i class="fa-regular fa-file-lines"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">PASIEN TERPANTAU</span>
            <span class="stat-value">{{ number_format($pasienTerpantau) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-green"><i class="fa-solid fa-users-viewfinder"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">KASUS AKTIF</span>
            <span class="stat-value">{{ number_format($kasusAktif) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-red"><i class="fa-solid fa-virus"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">IMUNISASI</span>
            <span class="stat-value">{{ number_format($imunisasi) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-purple"><i class="fa-solid fa-shield-virus"></i></div>
    </div>
    
    <!-- Row 2 -->
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">VAKSINASI</span>
            <span class="stat-value">{{ number_format($vaksinasi) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-blue"><i class="fa-solid fa-syringe"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">PENCEGAHAN STUNTING</span>
            <span class="stat-value">{{ number_format($pencegahanStunting) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-orange"><i class="fa-solid fa-child"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">KARTU SEHAT</span>
            <span class="stat-value">{{ number_format($kartuSehat) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-teal"><i class="fa-solid fa-address-card"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">UPDATE TERAKHIR</span>
            <span class="stat-value">Hari Ini</span>
        </div>
        <div class="stat-icon-wrapper icon-gray"><i class="fa-solid fa-pen-to-square"></i></div>
    </div>
</div>

<h3 class="section-title">Program Kesehatan Utama</h3>
<div class="program-grid">
    <!-- Card 1 -->
    <div class="program-card">
        <div class="program-card-header">
            <div class="program-card-title">Pencegahan Stunting</div>
            <div class="badge-aktif">Aktif</div>
        </div>
        <div class="program-value">1,240 Data</div>
        <div class="program-subtitle">Target: 1.800 Data</div>
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress Capaian</span>
                <span>69%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill fill-orange" style="width: 69%"></div>
            </div>
        </div>
        <a href="{{ route('kesehatan.program.index') }}" class="btn-detail">Lihat Detail</a>
    </div>

    <!-- Card 2 -->
    <div class="program-card">
        <div class="program-card-header">
            <div class="program-card-title">Vaksin Covid-19</div>
            <div class="badge-aktif">Aktif</div>
        </div>
        <div class="program-value">120,400 Dosis</div>
        <div class="program-subtitle">Target: 140.000 Dosis</div>
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress Capaian</span>
                <span>86%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: 86%"></div>
            </div>
        </div>
        <a href="{{ route('kesehatan.program.index') }}" class="btn-detail">Lihat Detail</a>
    </div>

    <!-- Card 3 -->
    <div class="program-card">
        <div class="program-card-header">
            <div class="program-card-title">Imunisasi Balita</div>
            <div class="badge-selesai">Selesai</div>
        </div>
        <div class="program-value">85,210 Anak</div>
        <div class="program-subtitle">Target: 85.000 Anak</div>
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress Capaian</span>
                <span>100%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill fill-green" style="width: 100%"></div>
            </div>
        </div>
        <a href="{{ route('kesehatan.program.index') }}" class="btn-detail">Lihat Detail</a>
    </div>

    <!-- Card 4 -->
    <div class="program-card">
        <div class="program-card-header">
            <div class="program-card-title">Distribusi Kartu Sehat</div>
            <div class="badge-aktif">Aktif</div>
        </div>
        <div class="program-value">32,150 KK</div>
        <div class="program-subtitle">Target: 50.000 KK</div>
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress Capaian</span>
                <span>64%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: 64%"></div>
            </div>
        </div>
        <a href="{{ route('kesehatan.program.index') }}" class="btn-detail">Lihat Detail</a>
    </div>
</div>
@endsection
