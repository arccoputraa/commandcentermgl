@extends('layouts.finance')

@section('title', 'Dashboard Keuangan')

@section('content')
<style>
    /* Custom CSS for Finance Dashboard to replace Tailwind */
    .finance-header {
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .finance-header h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    .finance-header p {
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
    }
    .metric-card.alt-bg {
        background: #f8fafc;
        box-shadow: none;
    }
    .metric-label {
        font-size: 13.5px;
        color: #64748b;
        margin-bottom: 8px;
        font-weight: 500;
    }
    .metric-value {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
    }
    .metric-value.highlight {
        color: #2563eb;
    }
    
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .chart-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .chart-header h3 {
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
        margin: 0;
    }
    .chart-header button {
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        font-size: 16px;
        padding: 0;
    }
    .chart-header button:hover {
        color: #64748b;
    }
    .chart-container {
        position: relative;
        height: 250px;
        width: 100%;
    }
</style>

@php
    function formatLargeNumberDash($number) {
        if ($number >= 1000000000) {
            return 'Rp ' . str_replace('.0', '', number_format($number / 1000000000, 1, ',', '.')) . ' M';
        } elseif ($number >= 1000000) {
            return 'Rp ' . str_replace('.0', '', number_format($number / 1000000, 1, ',', '.')) . ' Juta';
        }
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
@endphp

<!-- Header -->
<div class="finance-header">
    <h2>Dashboard Keuangan</h2>
    <p>Ringkasan informasi keuangan, pendapatan daerah, dan realisasi anggaran.</p>
</div>

<!-- Search and Filter Bar -->
<div class="toolbar-container">
    <div class="search-input-wrapper">
        <i class="fa-solid fa-search"></i>
        <input type="text" placeholder="Cari data keuangan...">
    </div>
    <div class="toolbar-divider"></div>
    <button class="btn-filter">
        Terapkan Filter
    </button>
</div>

<!-- Metrics Grid Row 1 -->
<div class="metrics-grid">
    <div class="metric-card">
        <p class="metric-label">Total Pendapatan (Target)</p>
        <p class="metric-value">{{ formatLargeNumberDash($targetPAD) }}</p>
    </div>
    <div class="metric-card">
        <p class="metric-label">Total Belanja</p>
        <p class="metric-value">{{ formatLargeNumberDash($totalAnggaran) }}</p>
    </div>
    <div class="metric-card">
        <p class="metric-label">Sisa Anggaran</p>
        <p class="metric-value">{{ formatLargeNumberDash($sisaAnggaran) }}</p>
    </div>
    <div class="metric-card alt-bg">
        <p class="metric-label">Realisasi Belanja</p>
        <p class="metric-value">{{ formatLargeNumberDash($totalRealisasiBelanja) }}</p>
    </div>
</div>

<!-- Metrics Grid Row 2 -->
<div class="metrics-grid" style="margin-bottom: 24px;">
    <div class="metric-card">
        <p class="metric-label">Realisasi Pendapatan</p>
        <p class="metric-value">{{ formatLargeNumberDash($realisasiPAD) }}</p>
    </div>
    <div class="metric-card">
        <p class="metric-label">Persentase Realisasi PAD</p>
        <p class="metric-value highlight">{{ $persentaseRealisasiPAD }}%</p>
    </div>
    <div class="metric-card">
        <p class="metric-label">Pendapatan Pajak Daerah</p>
        <p class="metric-value">{{ formatLargeNumberDash($pajakDaerah) }}</p>
    </div>
    <div class="metric-card alt-bg" style="display: flex; flex-direction: column; justify-content: center;">
        <p class="metric-label">Terakhir Diperbarui</p>
        <p class="metric-value" style="display: flex; align-items: center; gap: 8px; font-size: 20px;">
            <i class="fa-regular fa-calendar" style="color: #94a3b8;"></i>
            {{ date('d M Y') }}
        </p>
    </div>
</div>

<!-- Charts Row -->
<div class="charts-grid">
    <!-- Chart 1 -->
    <div class="chart-card">
        <div class="chart-header">
            <h3>Realisasi Belanja</h3>
            <button><i class="fa-solid fa-ellipsis-vertical"></i></button>
        </div>
        <div class="chart-container">
            <canvas id="realisasiBelanjaChart"></canvas>
        </div>
    </div>

    <!-- Chart 2 -->
    <div class="chart-card">
        <div class="chart-header">
            <h3>Pendapatan Asli Daerah (PAD)</h3>
            <button><i class="fa-solid fa-ellipsis-vertical"></i></button>
        </div>
        <div class="chart-container">
            <canvas id="pendapatanPADChart"></canvas>
        </div>
    </div>
</div>
@endsection

@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Chart is defined (might take a moment to load from CDN)
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded!');
            return;
        }
        
        // Chart configurations
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.scale.grid.color = '#f1f5f9';

        // Realisasi Belanja Chart (Horizontal Bar)
        const ctxBelanja = document.getElementById('realisasiBelanjaChart');
        if (ctxBelanja) {
            new Chart(ctxBelanja.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labelBelanja) !!},
                    datasets: [{
                        label: 'Realisasi (Rp)',
                        data: {!! json_encode($dataBelanja) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 4,
                        barPercentage: 0.5,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 13, weight: 'normal' },
                            bodyFont: { size: 14, weight: 'bold' },
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { display: true, borderDash: [4, 4], drawBorder: false },
                            border: { display: false },
                            ticks: { display: false }
                        },
                        y: {
                            grid: { display: false, drawBorder: false },
                            border: { display: false },
                            ticks: { color: '#475569', font: { size: 12 } }
                        }
                    }
                }
            });
        }

        // Pendapatan PAD Chart (Horizontal Bar)
        const ctxPAD = document.getElementById('pendapatanPADChart');
        if (ctxPAD) {
            new Chart(ctxPAD.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labelPad) !!},
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: {!! json_encode($dataPad) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 4,
                        barPercentage: 0.5,
                        categoryPercentage: 0.8
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 13, weight: 'normal' },
                            bodyFont: { size: 14, weight: 'bold' },
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { display: true, borderDash: [4, 4], drawBorder: false },
                            border: { display: false },
                            ticks: { display: false }
                        },
                        y: {
                            grid: { display: false, drawBorder: false },
                            border: { display: false },
                            ticks: { color: '#475569', font: { size: 12 } }
                        }
                    }
                }
            });
        }
    });
</script>
