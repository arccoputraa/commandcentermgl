@extends('layouts.app')
@section('title', 'Kesehatan - Command Center Kota Magelang')
@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Kesehatan</span>
    </div>

    <!-- Hero -->
    <div class="dashboard-hero bg-green-light">
        <h1 class="dashboard-hero-title">Pusat Data Kesehatan</h1>
        <p class="dashboard-hero-desc">Pantau perkembangan status kesehatan masyarakat secara real-time</p>
    </div>

    <!-- Stats -->
    <div class="dashboard-stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Total Program / Faskes</h3>
            <p class="stat-card-value">128</p>
            <p class="stat-card-desc">Fasilitas kesehatan aktif</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Pasien Terpantau</h3>
            <p class="stat-card-value">12,450</p>
            <p class="stat-card-desc">Masyarakat menerima layanan</p>
        </div>
        <div class="stat-card color-red">
            <h3 class="stat-card-title">Kasus Aktif / Perhatian Khusus</h3>
            <p class="stat-card-value">86</p>
            <p class="stat-card-desc">Membutuhkan penanganan segera</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select><option>Pilih Puskesmas / RS</option></select>
            <select><option>Pilih Kecamatan</option></select>
            <select><option>Bulan</option></select>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="dashboard-layout-sidebar">
        <!-- Main Column (Charts) -->
        <div class="dashboard-main-col">
            <!-- Map Placeholder -->
            <div class="dashboard-chart-card" style="padding: 16px;">
                <h3 class="chart-header" style="margin-bottom: 16px;">Peta Sebaran Kasus</h3>
                <div class="map-placeholder">
                    [ Peta Interaktif Sebaran Kasus Kesehatan ]
                </div>
            </div>

            <div class="dashboard-charts-grid" style="margin-top: 0;">
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Top 5 Penyakit</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="topPenyakitChart"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Kasus Aktif Berdasarkan Wilayah</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="kasusWilayahChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="dashboard-sidebar-col">
            <div class="summary-widget">
                <h3 class="summary-widget-title">Program Prioritas</h3>
                <p class="summary-widget-subtitle">
                    <span style="width:8px; height:8px; border-radius:50%; background:#00BC7D;"></span>
                    Bulan Berjalan
                </p>
                <div class="summary-list">
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Cakupan Vaksinasi</p>
                            </div>
                        </div>
                        <p class="summary-item-value">92%</p>
                    </div>
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Pencegahan Stunting</p>
                            </div>
                        </div>
                        <p class="summary-item-value">4,210 <span style="font-size:12px; font-weight:400; color:var(--slate-500)">anak</span></p>
                    </div>
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon orange">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Distribusi Kartu Sehat</p>
                            </div>
                        </div>
                        <p class="summary-item-value">15,000 <span style="font-size:12px; font-weight:400; color:var(--slate-500)">unit</span></p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-chart-card" style="margin-top: 24px;">
                <h3 class="chart-header">Fasilitas Tersedia</h3>
                <div class="chart-placeholder" style="height: 120px;">
                    [ Ketersediaan Tempat Tidur RS ]
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
    
    // Top 5 Penyakit
    const ctxTop = document.getElementById('topPenyakitChart').getContext('2d');
    new Chart(ctxTop, {
        type: 'bar',
        data: {
            labels: ['ISPA', 'Hipertensi', 'Diabetes', 'Diare', 'Demam Berdarah'],
            datasets: [{
                label: 'Jumlah Kasus',
                data: [1200, 950, 780, 450, 320],
                backgroundColor: '#009966',
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#E2E8F0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Kasus Aktif Berdasarkan Wilayah
    const ctxWilayah = document.getElementById('kasusWilayahChart').getContext('2d');
    new Chart(ctxWilayah, {
        type: 'pie',
        data: {
            labels: ['Magelang Utara', 'Magelang Tengah', 'Magelang Selatan'],
            datasets: [{
                data: [45, 25, 16],
                backgroundColor: ['#00BC7D', '#E17100', '#E7000B'],
                borderWidth: 0,
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
});
</script>
