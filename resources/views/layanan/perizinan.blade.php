@extends('layouts.app')
@section('title', 'Perizinan - Command Center Kota Magelang')
@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Perizinan</span>
    </div>

    <!-- Hero -->
    <div class="dashboard-hero">
        <h1 class="dashboard-hero-title">Pusat Data Perizinan</h1>
        <p class="dashboard-hero-desc">Informasi publik dan statistik sektoral Perizinan</p>
    </div>

    <!-- Stats -->
    <div class="dashboard-stats-grid">
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Total Layanan / Dokumen</h3>
            <p class="stat-card-value">3,169</p>
            <p class="stat-card-desc">Total data tercatat di sistem</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Selesai / Disetujui</h3>
            <p class="stat-card-value">2,850</p>
            <p class="stat-card-desc">Dokumen telah diterbitkan</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Dalam Proses</h3>
            <p class="stat-card-value">274</p>
            <p class="stat-card-desc">Sedang dalam tahap verifikasi</p>
        </div>
        <div class="stat-card color-red">
            <h3 class="stat-card-title">Perlu Tindak Lanjut / Ditolak</h3>
            <p class="stat-card-value">45</p>
            <p class="stat-card-desc">Dikembalikan ke pemohon / diarsipkan</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select><option>Pilih Tahun</option></select>
            <select><option>Pilih Jenis Izin</option></select>
            <select><option>Pilih Status</option></select>
        </div>
        <div class="filter-search">
            <input type="text" placeholder="Cari dokumen..." />
            <button class="btn btn-primary">Terapkan Filter</button>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="dashboard-layout-sidebar">
        <!-- Main Column (Charts) -->
        <div class="dashboard-main-col">
            <div class="dashboard-charts-grid">
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Tren Data Bulanan</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="trenBulananChart"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Komposisi Status Izin</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="komposisiStatusChart"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Tren Status Izin</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="trenStatusChart"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Jenis Permohonan</h3>
                    <div class="chart-container" style="position: relative; height: 256px; width: 100%;">
                        <canvas id="jenisPermohonanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="dashboard-sidebar-col">
            <div class="summary-widget">
                <h3 class="summary-widget-title">Detail Ringkasan Perizinan</h3>
                <p class="summary-widget-subtitle">
                    <span style="width:8px; height:8px; border-radius:50%; background:#00BC7D;"></span>
                    Live Update: Hari ini, 08:00 WIB
                </p>
                <div class="summary-list">
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Total Pengajuan</p>
                            </div>
                        </div>
                        <p class="summary-item-value">3,169</p>
                    </div>
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Layanan Baru</p>
                            </div>
                        </div>
                        <p class="summary-item-value">1,800</p>
                    </div>
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon orange">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 2v6h-6"></path><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v6h6"></path><path d="M21 12a9 9 0 1 0-9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Perpanjangan</p>
                            </div>
                        </div>
                        <p class="summary-item-value">1,324</p>
                    </div>
                    <div class="summary-list-item">
                        <div class="summary-item-left">
                            <div class="summary-icon slate">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            </div>
                            <div>
                                <p class="summary-item-title">Lainnya</p>
                            </div>
                        </div>
                        <p class="summary-item-value">45</p>
                    </div>
                </div>
            </div>

            <div class="summary-widget" style="margin-top: 24px;">
                <h3 class="summary-widget-title" style="font-size: 16px;">Informasi &amp; Publikasi</h3>
                <div style="margin-top: 16px;">
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Publikasi Data Perizinan Q1</p>
                            <span class="table-badge success">Rilis</span>
                        </div>
                        <p class="pub-info-meta">Diperbarui 2 hari yang lalu</p>
                    </div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Publikasi Data Perizinan Q2</p>
                            <span class="table-badge success">Rilis</span>
                        </div>
                        <p class="pub-info-meta">Diperbarui 4 hari yang lalu</p>
                    </div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Publikasi Data Perizinan Q3</p>
                            <span class="table-badge success">Rilis</span>
                        </div>
                        <p class="pub-info-meta">Diperbarui 6 hari yang lalu</p>
                    </div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Publikasi Data Perizinan Q4</p>
                            <span class="table-badge success">Rilis</span>
                        </div>
                        <p class="pub-info-meta">Diperbarui 8 hari yang lalu</p>
                    </div>
                </div>
                <button class="btn btn-primary" style="width: 100%; margin-top: 16px;">Unduh Rekap Data (PDF)</button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="dashboard-table-card">
        <div class="dashboard-table-header">
            <h3 class="dashboard-table-title">Daftar Dokumen Publik</h3>
            <p class="dashboard-table-desc">Tampilan data ringkas yang aman untuk dikonsumsi umum.</p>
        </div>
        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>No. Permohonan</th>
                        <th>Jenis Izin</th>
                        <th>Jenis Permohonan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="strong">DOC-2023-001</td>
                        <td>Layanan Umum</td>
                        <td>Baru</td>
                        <td>Pembangunan</td>
                        <td>01 Okt 2023</td>
                        <td><span class="table-badge success">Disetujui</span></td>
                        <td><a href="#" style="color:var(--blue); font-weight:500;">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td class="strong">DOC-2023-005</td>
                        <td>Rekomendasi</td>
                        <td>Perpanjangan</td>
                        <td>Kesehatan</td>
                        <td>05 Okt 2023</td>
                        <td><span class="table-badge warning">Proses</span></td>
                        <td><a href="#" style="color:var(--blue); font-weight:500;">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td class="strong">DOC-2023-012</td>
                        <td>Izin Usaha</td>
                        <td>Baru</td>
                        <td>Perdagangan</td>
                        <td>12 Okt 2023</td>
                        <td><span class="table-badge success">Disetujui</span></td>
                        <td><a href="#" style="color:var(--blue); font-weight:500;">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td class="strong">DOC-2023-018</td>
                        <td>IMB</td>
                        <td>Baru</td>
                        <td>Pembangunan</td>
                        <td>18 Okt 2023</td>
                        <td><span class="table-badge danger">Ditolak</span></td>
                        <td><a href="#" style="color:var(--blue); font-weight:500;">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td class="strong">DOC-2023-022</td>
                        <td>Layanan Umum</td>
                        <td>Perpanjangan</td>
                        <td>Pendidikan</td>
                        <td>22 Okt 2023</td>
                        <td><span class="table-badge warning">Proses</span></td>
                        <td><a href="#" style="color:var(--blue); font-weight:500;">Lihat Detail</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="dashboard-table-footer">
            <button class="btn btn-outline">Muat Lebih Banyak Data</button>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Defaults
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#62748E';
    
    // 1. Tren Data Bulanan (Bar Chart)
    const ctxTren = document.getElementById('trenBulananChart').getContext('2d');
    new Chart(ctxTren, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Layanan',
                data: [120, 190, 150, 220, 180, 250, 210, 290, 260, 310, 280, 340],
                backgroundColor: '#155DFC',
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

    // 2. Komposisi Status Izin (Pie Chart)
    const ctxKomposisi = document.getElementById('komposisiStatusChart').getContext('2d');
    new Chart(ctxKomposisi, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Proses', 'Ditolak'],
            datasets: [{
                data: [2850, 274, 45],
                backgroundColor: ['#009966', '#E17100', '#E7000B'],
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

    // 3. Tren Status Izin (Line Chart)
    const ctxTrenStatus = document.getElementById('trenStatusChart').getContext('2d');
    new Chart(ctxTrenStatus, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [
                { label: 'Disetujui', data: [80, 120, 100, 150, 130, 170], borderColor: '#009966', backgroundColor: '#009966', tension: 0.4 },
                { label: 'Proses', data: [20, 30, 25, 40, 35, 50], borderColor: '#E17100', backgroundColor: '#E17100', tension: 0.4 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#E2E8F0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 4. Jenis Permohonan (Pie Chart)
    const ctxJenis = document.getElementById('jenisPermohonanChart').getContext('2d');
    new Chart(ctxJenis, {
        type: 'doughnut',
        data: {
            labels: ['Baru', 'Perpanjangan', 'Lainnya'],
            datasets: [{
                data: [1800, 1324, 45],
                backgroundColor: ['#155DFC', '#00BC7D', '#CAD5E2'],
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
});
</script>
