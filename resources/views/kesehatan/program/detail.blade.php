@extends('layouts.kesehatan')

@section('title', 'Detail Program Kesehatan')

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
    
    .info-banner {
        background: #F0FDF4;
        border: 1px solid #10B981;
        border-radius: 8px;
        padding: 16px;
        color: #065F46;
        font-size: 14px;
        margin-bottom: 24px;
        border-left: 4px solid #10B981;
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
        grid-template-columns: 1fr 2fr;
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
    .btn-edit {
        padding: 6px 12px;
        border: 1px solid #10B981;
        color: #10B981;
        background: transparent;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .target-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .target-item {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }
    .target-label {
        color: #64748B;
    }
    .target-value {
        font-weight: 600;
        color: #1E293B;
    }
    
    .badge-warning {
        background: #FFF7ED;
        color: #F59E0B;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="breadcrumb">
    <a href="{{ route('kesehatan.dashboard') }}">Dashboard Kesehatan</a> / 
    <a href="{{ route('kesehatan.program.index') }}">Program Kesehatan</a> / Detail Program
</div>

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Program Pencegahan Stunting</h1>
        <p class="page-subtitle">Kelola target dan capaian bulanan program.</p>
    </div>
    <a href="{{ route('kesehatan.program.index') }}" class="btn-back">Kembali</a>
</div>

<div class="info-banner">
    Data target dan capaian program ini digunakan untuk memperbarui Program Kesehatan Utama dan Komposisi Program Kesehatan pada Dashboard Kesehatan.
</div>

<div class="stats-row">
    <div class="stat-box">
        <div class="stat-box-label">TARGET TAHUNAN</div>
        <div class="stat-box-value">1.800</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">TOTAL CAPAIAN</div>
        <div class="stat-box-value">1.240</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">SISA TARGET</div>
        <div class="stat-box-value">560</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">PERSENTASE</div>
        <div class="stat-box-value">69%</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">STATUS</div>
        <div class="stat-box-value" style="color:#F59E0B; font-size: 18px;">Perlu Perhatian</div>
    </div>
    <div class="stat-box">
        <div class="stat-box-label">UPDATE TERAKHIR</div>
        <div class="stat-box-value" style="font-size: 18px;">10 Nov 2026</div>
    </div>
</div>

<div class="bottom-grid">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Target Program</div>
            <button class="btn-edit">Edit Target</button>
        </div>
        <div class="target-list">
            <div class="target-item">
                <span class="target-label">Tahun</span>
                <span class="target-value">2026</span>
            </div>
            <div class="target-item">
                <span class="target-label">Target Tahunan</span>
                <span class="target-value">1.800</span>
            </div>
            <div class="target-item">
                <span class="target-label">Satuan</span>
                <span class="target-value">anak</span>
            </div>
            <div class="target-item" style="align-items: center;">
                <span class="target-label">Status Target</span>
                <span class="badge-warning">Perlu Perhatian</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Capaian Program per Bulan</div>
        </div>
        <div class="chart-container">
            <canvas id="capaianChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('capaianChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Capaian',
                data: [190, 210, 205, 215, 200, 220],
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
                    max: 300,
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
