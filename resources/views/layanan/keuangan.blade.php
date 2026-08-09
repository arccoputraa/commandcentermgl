@extends('layouts.app')
@section('title', 'Keuangan - Command Center Kota Magelang')
@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Keuangan</span>
    </div>

    <!-- Hero -->
    <div class="dashboard-hero bg-blue-light">
        <h1 class="dashboard-hero-title">Pusat Data Keuangan</h1>
        <p class="dashboard-hero-desc">Transparansi anggaran dan realisasi APBD Kota Magelang</p>
    </div>

    <!-- Stats -->
    <div class="dashboard-stats-grid">
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Total Anggaran</h3>
            <p class="stat-card-value" style="font-size: 24px;">Rp 1.2 Triliun</p>
            <p class="stat-card-desc">APBD Tahun Berjalan</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Total Realisasi</h3>
            <p class="stat-card-value" style="font-size: 24px;">Rp 850 Miliar</p>
            <p class="stat-card-desc">Realisasi per kuartal ini</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Persentase Realisasi</h3>
            <p class="stat-card-value">70.8%</p>
            <p class="stat-card-desc">Dari target tahunan</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Pendapatan Asli Daerah (PAD)</h3>
            <p class="stat-card-value" style="font-size: 24px;">Rp 210 Miliar</p>
            <p class="stat-card-desc">Target PAD tercapai: 85%</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select><option>Tahun Anggaran (2026)</option></select>
            <select><option>Pilih OPD</option></select>
            <select><option>Jenis Belanja</option></select>
        </div>
        <button class="btn btn-outline">Unduh Laporan</button>
    </div>

    <!-- Main Content Layout -->
    <div class="dashboard-layout-sidebar">
        <!-- Main Column (Charts) -->
        <div class="dashboard-main-col">
            <div class="dashboard-chart-card">
                <h3 class="chart-header">Anggaran vs Realisasi per Urusan</h3>
                <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                    <canvas id="anggaranRealisasiChart"></canvas>
                </div>
            </div>

            <div class="dashboard-charts-grid" style="margin-top: 0;">
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Komposisi Pendapatan</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="komposisiPendapatanChart"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Serapan Anggaran Tertinggi</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="serapanAnggaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="dashboard-sidebar-col">
            <div class="summary-widget">
                <h3 class="summary-widget-title">Rincian Pendapatan</h3>
                <p class="summary-widget-subtitle">
                    <span style="width:8px; height:8px; border-radius:50%; background:#00BC7D;"></span>
                    Update Terakhir: Kemarin
                </p>
                <div class="summary-list">
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Pendapatan Pajak Daerah</p>
                            </div>
                        </div>
                        <p class="summary-item-value" style="font-size: 15px;">Rp 120 M</p>
                    </div>
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Dana Perimbangan</p>
                            </div>
                        </div>
                        <p class="summary-item-value" style="font-size: 15px;">Rp 650 M</p>
                    </div>
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon orange">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Retribusi Daerah</p>
                            </div>
                        </div>
                        <p class="summary-item-value" style="font-size: 15px;">Rp 45 M</p>
                    </div>
                </div>
            </div>
            
            <div class="summary-widget" style="margin-top: 24px;">
                <h3 class="summary-widget-title" style="font-size: 16px;">Dokumen Anggaran</h3>
                <div style="margin-top: 16px;">
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Ringkasan APBD 2026</p>
                        </div>
                        <a href="#" style="font-size: 13px; color: var(--blue); font-weight: 500;">Unduh PDF</a>
                    </div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">LKPJ Walikota 2025</p>
                        </div>
                        <a href="#" style="font-size: 13px; color: var(--blue); font-weight: 500;">Unduh PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#62748E';
    
    // Anggaran vs Realisasi per Urusan
    const ctxAnggaran = document.getElementById('anggaranRealisasiChart').getContext('2d');
    new Chart(ctxAnggaran, {
        type: 'bar',
        data: {
            labels: ['Pendidikan', 'Kesehatan', 'PUPR', 'Sosial', 'Trantibum', 'Lainnya'],
            datasets: [
                {
                    label: 'Anggaran',
                    data: [350, 250, 200, 150, 100, 150],
                    backgroundColor: '#155DFC',
                    borderRadius: 4,
                },
                {
                    label: 'Realisasi',
                    data: [280, 180, 120, 110, 80, 80],
                    backgroundColor: '#009966',
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top', labels: { usePointStyle: true } } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#E2E8F0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Komposisi Pendapatan
    const ctxKomposisi = document.getElementById('komposisiPendapatanChart').getContext('2d');
    new Chart(ctxKomposisi, {
        type: 'doughnut',
        data: {
            labels: ['Dana Perimbangan', 'PAD', 'Lain-lain PAD yang Sah'],
            datasets: [{
                data: [650, 210, 45],
                backgroundColor: ['#00BC7D', '#9810FA', '#E17100'],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });

    // Serapan Anggaran Tertinggi
    const ctxSerapan = document.getElementById('serapanAnggaranChart').getContext('2d');
    new Chart(ctxSerapan, {
        type: 'bar',
        data: {
            labels: ['Dinas Pendidikan', 'Dinas Kesehatan', 'Dinas Sosial', 'Satpol PP'],
            datasets: [{
                label: 'Persentase Serapan (%)',
                data: [85, 78, 72, 68],
                backgroundColor: '#00BC7D',
                borderRadius: 4,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, max: 100, grid: { borderDash: [4, 4], color: '#E2E8F0' } },
                y: { grid: { display: false } }
            }
        }
    });
});
</script>
