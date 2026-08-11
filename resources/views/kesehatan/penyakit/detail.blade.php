@extends('layouts.kesehatan')

@section('title', 'Detail Penyakit')

@push('styles')
<style>
    .breadcrumb {
        font-size: 14px;
        color: #64748B;
        margin-bottom: 24px;
    }
    .breadcrumb a {
        color: #3B82F6;
        text-decoration: none;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
    }
    .page-subtitle {
        color: #64748B;
        font-size: 14px;
    }
    .btn-back {
        padding: 8px 16px;
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        color: #1E293B;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .stats-row {
        display: flex;
        gap: 20px;
        margin-bottom: 24px;
    }
    .stat-box {
        flex: 1;
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 24px;
    }
    .stat-box-label {
        font-size: 11px;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .stat-box-value {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
    }

    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 24px;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    .map-placeholder {
        background: #F1F5F9;
        border-radius: 8px;
        height: 200px;
        margin-bottom: 16px;
    }
    
    .list-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 14px;
    }
    .list-item:last-child {
        border-bottom: none;
    }
    .list-label {
        color: #64748B;
    }
    .list-value {
        font-weight: 600;
        color: #1E293B;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="breadcrumb">
    <a href="{{ route('kesehatan.dashboard') }}">Dashboard Kesehatan</a> / 
    <a href="{{ route('kesehatan.penyakit.index') }}">Data Penyakit</a> / Detail
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Penyakit {{ $penyakit['nama'] }}</h1>
        <p class="page-subtitle">Rincian data kasus bulanan dan peta sebaran wilayah.</p>
    </div>
    <a href="{{ route('kesehatan.penyakit.index') }}" class="btn-back">Kembali</a>
</div>

<div class="stats-row">
    <div class="stat-box">
        <div class="stat-box-label">NAMA PENYAKIT</div>
        <div class="stat-box-value">{{ $penyakit['nama'] }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">TOTAL KASUS</div>
        <div class="stat-box-value">{{ number_format($penyakit['jumlah']) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">UPDATE TERAKHIR</div>
        <div class="stat-box-value" style="font-size: 18px; margin-top: 6px;">{{ $penyakit['update'] }}</div>
    </div>
</div>

<div class="bottom-grid">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tren {{ $penyakit['nama'] }} 6 Bulan</div>
        </div>
        <div class="chart-container">
            <canvas id="trenChart"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Peta Sebaran Kasus</div>
        </div>
        <div class="map-placeholder"></div>
        
        <div>
            <div class="list-item">
                <span class="list-label">Magelang Tengah</span>
                <span class="list-value">420 kasus</span>
            </div>
            <div class="list-item">
                <span class="list-label">Magelang Utara</span>
                <span class="list-value">430 kasus</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('trenChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Okt', 'Nov', 'Des', 'Jan', 'Feb', 'Mar'],
            datasets: [{
                label: 'Kasus',
                data: [120, 150, 110, 200, 180, 220],
                backgroundColor: '#10B981',
                borderRadius: 4,
                barThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F1F5F9'
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
