@extends('layouts.perizinan')

@section('title', 'Dashboard Perizinan')

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
    }
    .btn-primary-custom {
        background: #2563EB;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-primary-custom:hover {
        background: #1D4ED8;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .icon-blue { background: #EFF6FF; color: #2563EB; }
    .icon-green { background: #F0FDF4; color: #16A34A; }
    .icon-yellow { background: #FEFCE8; color: #CA8A04; }
    .icon-red { background: #FEF2F2; color: #DC2626; }
    .icon-purple { background: #FAF5FF; color: #9333EA; }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #0F172A;
    }
    .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .bottom-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }
    .chart-card, .list-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 20px;
    }
    .placeholder-chart {
        height: 250px;
        background: #F8FAFC;
        border-radius: 8px;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        padding: 20px;
    }
    .bar {
        width: 40px;
        background: #2563EB;
        border-radius: 4px 4px 0 0;
    }
    .list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #F1F5F9;
    }
    .list-item:last-child {
        border-bottom: none;
    }
    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    .dot-green { background: #16A34A; }
    .dot-yellow { background: #CA8A04; }
    .list-label {
        flex: 1;
        font-size: 14px;
        color: #334155;
    }
    .list-value {
        font-weight: 600;
        color: #0F172A;
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1>Dashboard Perizinan</h1>
    <p>Pantau statistik pengajuan dan penerbitan izin terkini.</p>
</div>

<div class="filter-bar">
    <input type="date" class="filter-input" placeholder="Start Date">
    <input type="date" class="filter-input" placeholder="End Date">
    <button class="btn-primary-custom" style="margin-left: auto;">Terapkan Filter</button>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-blue"><i class="fa-solid fa-file-lines"></i></div>
        <div class="stat-value">{{ number_format($totalPerizinan) }}</div>
        <div class="stat-label">TOTAL PERIZINAN</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-green"><i class="fa-solid fa-check-circle"></i></div>
        <div class="stat-value">{{ number_format($disetujui) }}</div>
        <div class="stat-label">DISETUJUI</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-yellow"><i class="fa-solid fa-clock"></i></div>
        <div class="stat-value">{{ number_format($proses) }}</div>
        <div class="stat-label">DALAM PROSES</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-red"><i class="fa-solid fa-xmark-circle"></i></div>
        <div class="stat-value">{{ number_format($ditolak) }}</div>
        <div class="stat-label">DITOLAK / PENDING</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-purple"><i class="fa-solid fa-ban"></i></div>
        <div class="stat-value">0</div>
        <div class="stat-label">DICABUT</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-blue"><i class="fa-solid fa-inbox"></i></div>
        <div class="stat-value">{{ number_format($hariIni) }}</div>
        <div class="stat-label">PERMOHONAN MASUK HARI INI</div>
    </div>
</div>

<div class="bottom-grid">
    <div class="chart-card">
        <h3 class="card-title">Tren Pengajuan Izin</h3>
        <div class="placeholder-chart">
            <div class="bar" style="height: 30%"></div>
            <div class="bar" style="height: 50%"></div>
            <div class="bar" style="height: 40%"></div>
            <div class="bar" style="height: 70%"></div>
            <div class="bar" style="height: 60%"></div>
            <div class="bar" style="height: 90%"></div>
            <div class="bar" style="height: 80%"></div>
        </div>
    </div>
    <div class="list-card">
        <h3 class="card-title">Permohonan Hari Ini</h3>
        <div style="font-size: 13px; color: #64748B; margin-bottom: 16px;">
            <i class="fa-solid fa-circle-info" style="color:#2563EB;"></i> Izin Terbaru
        </div>
        
        <div class="list-item">
            <div class="dot dot-green"></div>
            <div class="list-label">Disetujui Hari Ini</div>
            <div class="list-value">{{ number_format($disetujui) }}</div>
        </div>
        <div class="list-item">
            <div class="dot dot-yellow"></div>
            <div class="list-label">Masuk Proses</div>
            <div class="list-value">{{ number_format($proses) }}</div>
        </div>
    </div>
</div>
@endsection
