@extends('layouts.kesehatan')

@section('title', 'Daftar Program Kesehatan')

@push('styles')
<style>
    .page-header {
        margin-bottom: 24px;
    }
    .page-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
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
        min-width: 250px;
    }
    .search-input-wrapper {
        position: relative;
        flex: 1;
        max-width: 400px;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
    }
    .search-input-wrapper input {
        width: 100%;
        padding-left: 40px;
    }

    .program-list-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .program-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .program-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }
    .program-title {
        font-size: 18px;
        font-weight: 700;
        color: #1E293B;
    }
    .program-meta {
        font-size: 12px;
        color: #64748B;
        margin-bottom: 24px;
    }
    
    .stats-row {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-box {
        flex: 1;
        background: #F8FAFC;
        border-radius: 8px;
        padding: 16px;
    }
    .stat-box-label {
        font-size: 11px;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .stat-box-value {
        font-size: 20px;
        font-weight: 700;
        color: #1E293B;
    }
    .stat-box-unit {
        font-size: 12px;
        font-weight: 400;
        color: #64748B;
    }

    .progress-container {
        margin-bottom: 24px;
    }
    .progress-header {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #64748B;
        margin-bottom: 8px;
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

    .btn-action {
        display: block;
        width: 100%;
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-green {
        background: #009966;
        color: white;
    }
    .btn-green:hover { background: #008055; }
    
    .btn-blue {
        background: #3B82F6;
        color: white;
    }
    .btn-blue:hover { background: #2563EB; }

    .badge-aktif {
        background: #ECFDF5;
        color: #10B981;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-warning {
        background: #FFF7ED;
        color: #F59E0B;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Daftar Program Kesehatan</h1>
</div>

<div class="filter-bar">
    <div class="search-input-wrapper">
        <i class="fa-solid fa-search"></i>
        <input type="text" class="filter-input" placeholder="Search program...">
    </div>
</div>

<div class="program-list-grid">
    <!-- Card 1 -->
    <div class="program-card">
        <div class="program-header">
            <div class="program-title">Pencegahan Stunting</div>
            <div class="badge-warning">Perlu Perhatian</div>
        </div>
        <div class="program-meta">Update terakhir: 10 Nov 2026</div>
        
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-box-label">TARGET TAHUN</div>
                <div class="stat-box-value">1.800 <span class="stat-box-unit">anak</span></div>
            </div>
            <div class="stat-box">
                <div class="stat-box-label">CAPAIAN SAAT INI</div>
                <div class="stat-box-value">1.240 <span class="stat-box-unit">anak</span></div>
            </div>
        </div>
        
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress capaian</span>
                <span>69%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill fill-orange" style="width: 69%"></div>
            </div>
        </div>
        
        <a href="{{ route('kesehatan.program.detail', 1) }}" class="btn-action btn-green">Kelola Data Capaian</a>
    </div>

    <!-- Card 2 -->
    <div class="program-card">
        <div class="program-header">
            <div class="program-title">Vaksinasi</div>
            <div class="badge-aktif">Aktif</div>
        </div>
        <div class="program-meta">Update terakhir: 08 Nov 2026</div>
        
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-box-label">TARGET TAHUN</div>
                <div class="stat-box-value">140.000 <span class="stat-box-unit">dosis</span></div>
            </div>
            <div class="stat-box">
                <div class="stat-box-label">CAPAIAN SAAT INI</div>
                <div class="stat-box-value">120.400 <span class="stat-box-unit">dosis</span></div>
            </div>
        </div>
        
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress capaian</span>
                <span>86%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: 86%"></div>
            </div>
        </div>
        
        <a href="{{ route('kesehatan.program.detail', 2) }}" class="btn-action btn-green">Kelola Data Capaian</a>
    </div>

    <!-- Card 3 -->
    <div class="program-card">
        <div class="program-header">
            <div class="program-title">Imunisasi</div>
            <div class="badge-aktif">Aktif</div>
        </div>
        <div class="program-meta">Update terakhir: 10 Nov 2026</div>
        
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-box-label">TARGET TAHUN</div>
                <div class="stat-box-value">100.000 <span class="stat-box-unit">anak</span></div>
            </div>
            <div class="stat-box">
                <div class="stat-box-label">CAPAIAN SAAT INI</div>
                <div class="stat-box-value">85.210 <span class="stat-box-unit">anak</span></div>
            </div>
        </div>
        
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress capaian</span>
                <span>85%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill fill-green" style="width: 85%"></div>
            </div>
        </div>
        
        <a href="{{ route('kesehatan.program.detail', 3) }}" class="btn-action btn-green">Kelola Data Capaian</a>
    </div>

    <!-- Card 4 -->
    <div class="program-card">
        <div class="program-header">
            <div class="program-title">Kartu Sehat</div>
            <div class="badge-aktif">Aktif</div>
        </div>
        <div class="program-meta">Update terakhir: 09 Nov 2026</div>
        
        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-box-label">TARGET TAHUN</div>
                <div class="stat-box-value">50.000 <span class="stat-box-unit">KK</span></div>
            </div>
            <div class="stat-box">
                <div class="stat-box-label">CAPAIAN SAAT INI</div>
                <div class="stat-box-value">32.150 <span class="stat-box-unit">KK</span></div>
            </div>
        </div>
        
        <div class="progress-container">
            <div class="progress-header">
                <span>Progress capaian</span>
                <span>64%</span>
            </div>
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: 64%"></div>
            </div>
        </div>
        
        <a href="{{ route('kesehatan.program.detail', 4) }}" class="btn-action btn-green">Kelola Data Capaian</a>
    </div>
</div>
@endsection
