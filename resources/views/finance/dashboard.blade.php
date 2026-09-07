@extends('layouts.finance')

@section('title', 'Dashboard Keuangan')

@section('content')
<style>
    .finance-header {
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .finance-header h2 {
        font-size: 26px;
        font-weight: 700;
        color: #0F172A;
        margin: 0 0 6px 0;
    }
    .finance-header p {
        font-size: 14px;
        color: #64748B;
        margin: 0;
    }

    .finance-filter-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 12px 16px;
        margin-bottom: 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .finance-filter-bar select {
        flex: 1;
        padding: 10px 14px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        font-size: 13px;
        color: #334155;
        outline: none;
        transition: border-color 0.2s;
    }
    .finance-filter-bar select:focus {
        border-color: #155DFC;
    }
    .btn-apply-filter {
        background: #155DFC;
        color: #FFFFFF;
        padding: 10px 24px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-apply-filter:hover {
        background: #1048c7;
    }

    .metrics-grid-8 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .metric-card-box {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 20px 22px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .metric-card-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 8px 0;
    }
    .metric-card-num {
        font-size: 22px;
        font-weight: 800;
        color: #0F172A;
        margin: 0;
        line-height: 1.2;
    }

    .charts-grid-admin {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .chart-card-box {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .chart-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .chart-header-title {
        font-size: 13px;
        font-weight: 700;
        color: #0F172A;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }
    .chart-legend-row {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 11px;
        color: #64748B;
    }
    .chart-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .chart-legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    @media (max-width: 1024px) {
        .metrics-grid-8 {
            grid-template-columns: repeat(2, 1fr);
        }
        .charts-grid-admin {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 640px) {
        .metrics-grid-8 {
            grid-template-columns: 1fr;
        }
        .finance-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<!-- Header -->
<div class="finance-header">
    <h2>Dashboard Keuangan</h2>
    <p>Pantau anggaran, realisasi, pendapatan daerah, dan pajak daerah Kota Magelang.</p>
</div>

<!-- Filter Bar -->
<div class="finance-filter-bar">
    <select>
        <option value="">Tahun Anggaran (2026)</option>
        <option value="2026">2026</option>
        <option value="2025">2025</option>
    </select>
    <select>
        <option value="">Pilih Sub Bidang / Unit</option>
        <option value="sekretariat">Sekretariat</option>
        <option value="anggaran">Bidang Anggaran</option>
        <option value="akuntansi">Bidang Akuntansi</option>
        <option value="aset">Bidang Aset</option>
        <option value="pajak">Bidang Pajak</option>
    </select>
    <select>
        <option value="">Pilih Kategori / Periode</option>
        <option value="semua">Semua Periode</option>
        <option value="q1">Kuartal 1</option>
        <option value="q2">Kuartal 2</option>
        <option value="semester1">Semester 1</option>
        <option value="juli">Juli 2026</option>
    </select>
    <button class="btn-apply-filter">Terapkan Filter</button>
</div>

<!-- 8 Metric Cards (2 rows x 4 cols) -->
<div class="metrics-grid-8">
    <!-- Row 1 -->
    <div class="metric-card-box">
        <p class="metric-card-label">TOTAL ANGGARAN</p>
        <p class="metric-card-num">Rp{{ number_format($totalAnggaran / 1000000000, 1, ',', '.') }} M</p>
    </div>
    <div class="metric-card-box">
        <p class="metric-card-label">TOTAL REALISASI</p>
        <p class="metric-card-num">Rp{{ number_format($totalRealisasi / 1000000000, 1, ',', '.') }} M</p>
    </div>
    <div class="metric-card-box">
        <p class="metric-card-label">PERSENTASE REALISASI</p>
        <p class="metric-card-num">{{ number_format($persentaseRealisasi, 1, ',', '.') }}%</p>
    </div>
    <div class="metric-card-box">
        <p class="metric-card-label">TARGET PAD</p>
        <p class="metric-card-num">Rp{{ number_format($targetPAD / 1000000000, 1, ',', '.') }} M</p>
    </div>

    <!-- Row 2 -->
    <div class="metric-card-box">
        <p class="metric-card-label">REALISASI PAD</p>
        <p class="metric-card-num">Rp{{ number_format($realisasiPAD / 1000000000, 1, ',', '.') }} M</p>
    </div>
    <div class="metric-card-box">
        <p class="metric-card-label">PERSENTASE PAD</p>
        <p class="metric-card-num">{{ number_format($persentasePAD, 1, ',', '.') }}%</p>
    </div>
    <div class="metric-card-box">
        <p class="metric-card-label">PENDAPATAN PAJAK DAERAH</p>
        <p class="metric-card-num">Rp{{ number_format($pajakDaerah / 1000000000, 1, ',', '.') }} M</p>
    </div>
    <div class="metric-card-box">
        <p class="metric-card-label">UPDATE TERAKHIR</p>
        <p class="metric-card-num" style="font-size: 20px;">{{ $updateTerakhir ?? '03 Juli 2026' }}</p>
    </div>
</div>

<!-- Charts Grid -->
<div class="charts-grid-admin">
    <!-- Chart 1: ANGGARAN VS REALISASI -->
    <div class="chart-card-box">
        <div class="chart-header-row">
            <h3 class="chart-header-title">ANGGARAN VS REALISASI</h3>
            <div class="chart-legend-row">
                <span class="chart-legend-item">
                    <span class="chart-legend-dot" style="background: #155DFC;"></span> Anggaran
                </span>
                <span class="chart-legend-item">
                    <span class="chart-legend-dot" style="background: #00BC7D;"></span> Realisasi
                </span>
            </div>
        </div>
        <div style="position: relative; height: 260px; width: 100%;">
            <canvas id="adminAnggaranVsRealisasi"></canvas>
        </div>
    </div>

    <!-- Chart 2: TREN REALISASI ANGGARAN -->
    <div class="chart-card-box">
        <div class="chart-header-row">
            <h3 class="chart-header-title">TREN REALISASI ANGGARAN</h3>
            <div class="chart-legend-row">
                <span class="chart-legend-item">
                    <span class="chart-legend-dot" style="background: #00BC7D;"></span> Realisasi
                </span>
            </div>
        </div>
        <div style="position: relative; height: 260px; width: 100%;">
            <canvas id="adminTrendRealisasi"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js is not loaded');
        return;
    }

    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#64748B';

    const baseHorizontalOptions = {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1E293B',
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    borderDash: [4, 4],
                    color: '#F1F5F9'
                },
                ticks: {
                    font: { size: 11 }
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    font: { size: 12, weight: '500' },
                    color: '#334155'
                }
            }
        }
    };

    // 1. Chart Anggaran vs Realisasi (Horizontal Clustered Bar)
    const ctxAnggaran = document.getElementById('adminAnggaranVsRealisasi');
    if (ctxAnggaran) {
        new Chart(ctxAnggaran.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartAnggaran['labels'] ?? ['Sekretariat', 'Anggaran', 'Akuntansi', 'Aset', 'Pajak']) !!},
                datasets: [
                    {
                        label: 'Anggaran (M)',
                        data: {!! json_encode($chartAnggaran['anggaran'] ?? [5.2, 4.8, 3.6, 2.8, 6.0]) !!},
                        backgroundColor: '#155DFC',
                        borderRadius: 6,
                        barThickness: 8,
                        categoryPercentage: 0.8,
                        barPercentage: 0.9
                    },
                    {
                        label: 'Realisasi (M)',
                        data: {!! json_encode($chartAnggaran['realisasi'] ?? [4.4, 4.1, 3.4, 2.1, 5.5]) !!},
                        backgroundColor: '#00BC7D',
                        borderRadius: 6,
                        barThickness: 8,
                        categoryPercentage: 0.8,
                        barPercentage: 0.9
                    }
                ]
            },
            options: baseHorizontalOptions
        });
    }

    // 2. Chart Tren Realisasi Anggaran (Horizontal Bar Bulanan)
    const ctxTrend = document.getElementById('adminTrendRealisasi');
    if (ctxTrend) {
        new Chart(ctxTrend.getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartTrend['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) !!},
                datasets: [
                    {
                        label: 'Realisasi (M)',
                        data: {!! json_encode($chartTrend['data'] ?? [3.2, 5.8, 8.1, 11.6, 15.2, 18.9]) !!},
                        backgroundColor: '#00BC7D',
                        borderRadius: 6,
                        barThickness: 10
                    }
                ]
            },
            options: baseHorizontalOptions
        });
    }
});
</script>
@endpush
