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
                <div class="map-placeholder" style="border-radius: 8px; overflow: hidden; position: relative; height: 300px; background: #f1f5f9;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15828.910901596201!2d110.2078652!3d-7.4815454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a8f4c4054a8e3%3A0xc3b4cc374be2e022!2sMagelang%2C%20Magelang%20City%2C%20Central%20Java!5e0!3m2!1sen!2sid!4v1715000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div style="position: absolute; bottom: 16px; left: 0; right: 0; text-align: center;">
                        <button style="background: #009966; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Buka Peta Interaktif</button>
                    </div>
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
                <h3 class="chart-header" style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <i class="fa-solid fa-file-lines" style="color: #009966;"></i> Informasi Terbaru
                </h3>
                <div class="info-list">
                    @if(isset($informasi))
                        @foreach($informasi as $info)
                        <div class="info-item" style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 12px; display: flex; flex-direction: column; gap: 8px; transition: border-color 0.2s;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div style="display: flex; gap: 12px;">
                                    <i class="fa-solid fa-file-pdf" style="color: #ef4444; font-size: 20px; margin-top: 4px;"></i>
                                    <div>
                                        <h4 style="font-size: 14px; font-weight: 600; color: #1e293b; margin: 0;">{{ $info->judul }}</h4>
                                        <p style="font-size: 12px; color: #64748b; margin: 4px 0 0 0;">Dokumen PDF</p>
                                    </div>
                                </div>
                                <span style="background: #ecfdf5; color: #009966; padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: 600;">Rilis</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                                <span style="font-size: 11px; color: #94a3b8;">Diperbarui {{ \Carbon\Carbon::parse($info->created_at)->diffForHumans() }}</span>
                                <a href="{{ $info->file_pdf ? asset($info->file_pdf) : '#' }}" {{ $info->file_pdf ? 'target="_blank"' : '' }} style="font-size: 12px; font-weight: 600; color: #009966; text-decoration: none;">Lihat PDF</a>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div></div></div></div>@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#62748E';
    
    // Top 5 Penyakit
    const ctxTop = document.getElementById('topPenyakitChart').getContext('2d');
    new Chart(ctxTop, {
        type: 'bar',
                data: {
            labels: {!! isset($penyakit) ? json_encode($penyakit->pluck('nama')) : json_encode(['ISPA', 'Hipertensi', 'Diabetes', 'Diare', 'Demam Berdarah']) !!},
            datasets: [{
                label: 'Jumlah Kasus',
                data: {!! isset($penyakit) ? json_encode($penyakit->pluck('jumlah')) : json_encode([1200, 950, 780, 450, 320]) !!},
                backgroundColor: '#009966',
                borderRadius: 4,
            }]
        },
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
