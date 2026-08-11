@extends('layouts.app')

@section('title', 'Pembangunan - Command Center Kota Magelang')

@section('content')
@php
$stats = [
    ['label' => 'Total Proyek', 'value' => '32 Proyek'],
    ['label' => 'Proyek Berjalan', 'value' => '18 Proyek'],
    ['label' => 'Proyek Selesai', 'value' => '9 Proyek'],
    ['label' => 'Proyek Tertunda', 'value' => '3 Proyek'],
    ['label' => 'Total Anggaran', 'value' => 'Rp28,5 M'],
    ['label' => 'Total Realisasi', 'value' => 'Rp19,8 M'],
    ['label' => 'Rata-rata Progres Fisik', 'value' => '74%'],
    ['label' => 'Update Terakhir', 'value' => '03 Juli 2026'],
];

$tabelProyek = [
    ['kode' => 'PRJ-2026-001', 'nama' => 'Peningkatan Jalan Tidar Selatan', 'kategori' => 'Jalan & Jembatan', 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Tidar Selatan', 'anggaran' => 'Rp1,8 M', 'progres' => '72%', 'status' => 'Berjalan', 'badge' => 'text-amber-600'],
    ['kode' => 'PRJ-2026-002', 'nama' => 'Rehabilitasi Drainase Panjang', 'kategori' => 'Drainase', 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'anggaran' => 'Rp850 Juta', 'progres' => '58%', 'status' => 'Berjalan', 'badge' => 'text-amber-600'],
    ['kode' => 'PRJ-2026-003', 'nama' => 'Renovasi Gedung Pelayanan Publik', 'kategori' => 'Gedung Pemerintahan', 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Kemirirejo', 'anggaran' => 'Rp2,4 M', 'progres' => '34%', 'status' => 'Perlu Perhatian', 'badge' => 'text-red-600'],
    ['kode' => 'PRJ-2026-004', 'nama' => 'Pembangunan Taman Kelurahan', 'kategori' => 'Ruang Terbuka Hijau', 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'anggaran' => 'Rp620 Juta', 'progres' => '100%', 'status' => 'Selesai', 'badge' => 'text-green-600'],
    ['kode' => 'PRJ-2026-005', 'nama' => 'Perbaikan Fasilitas Pasar Rejowinangun', 'kategori' => 'Fasilitas Umum', 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Rejowinangun', 'anggaran' => 'Rp1,2 M', 'progres' => '25%', 'status' => 'Tertunda', 'badge' => 'text-red-500'],
];

$infoTerbaru = [
    ['judul' => 'Laporan Progres Pembangunan Semester I 2026', 'kategori' => 'Laporan Progres Pembangunan', 'tanggal' => '03 Jul 2026', 'status' => 'Rilis', 'badge' => 'bg-green-100 text-green-700'],
    ['judul' => 'Rekap Proyek Infrastruktur 2026', 'kategori' => 'Rekap Proyek', 'tanggal' => '02 Jul 2026', 'status' => 'Rilis', 'badge' => 'bg-green-100 text-green-700'],
    ['judul' => 'Publikasi Pembangunan Fasilitas Umum', 'kategori' => 'Publikasi Infrastruktur', 'tanggal' => '01 Jul 2026', 'status' => 'Draft', 'badge' => 'bg-amber-100 text-amber-700'],
    ['judul' => 'Laporan Realisasi Pembangunan Triwulan II', 'kategori' => 'Laporan Realisasi Pembangunan', 'tanggal' => '02 Jul 2026', 'status' => 'Rilis', 'badge' => 'bg-green-100 text-green-700'],
];

$dokumentasi = [
    ['judul' => 'Foto Progres Minggu Ke-4', 'sub' => 'Peningkatan Jalan Tidar Selatan · 28 Jun 2026'],
    ['judul' => 'Dokumentasi Drainase Sisi Utara', 'sub' => 'Rehabilitasi Drainase Panjang · Pemasangan saluran beton'],
    ['judul' => 'Laporan Progres Juni', 'sub' => 'Renovasi Gedung Pelayanan Publik · Laporan progres fisik dan anggaran'],
];
@endphp

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Pembangunan</span>
    </div>

    <h1 class="page-title">Pembangunan</h1>

    <div class="dashboard-hero bg-yellow-light">
        <h2 class="dashboard-hero-title">Pusat Data Pembangunan</h2>
        <p class="dashboard-hero-desc">Informasi publik dan statistik sektoral pembangunan Kota Magelang.</p>
    </div>

    <div class="dashboard-stats-grid" style="margin-top: 24px;">
        @foreach ($stats as $stat)
            <div class="stat-card">
                <h3 class="stat-card-title">{{ $stat['label'] }}</h3>
                <p class="stat-card-value">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select><option>Kecamatan</option></select>
            <select><option>Kategori</option></select>
            <select><option>Status</option></select>
            <select><option>Tahun</option></select>
        </div>
        <div class="filter-search" style="flex:1; min-width:260px;">
            <input type="text" placeholder="Search proyek" />
        </div>
        <button class="btn btn-primary">Terapkan Filter</button>
    </div>

    <div class="dashboard-charts-grid">
        <div class="dashboard-chart-card">
            <h3 class="chart-header">Progres Proyek per Bulan</h3>
            <div id="chartProgres" style="min-height: 260px;"></div>
        </div>
        <div class="dashboard-chart-card">
            <h3 class="chart-header">Status Proyek</h3>
            <div id="chartStatusProyek" style="min-height: 260px;"></div>
        </div>
        <div class="dashboard-chart-card">
            <h3 class="chart-header">Realisasi Anggaran Pembangunan</h3>
            <div id="chartRealisasi" style="min-height: 260px;"></div>
        </div>
        <div class="dashboard-chart-card">
            <h3 class="chart-header">Proyek Berdasarkan Kategori</h3>
            <div id="chartKategori" style="min-height: 260px;"></div>
        </div>
    </div>

    <div class="dashboard-layout-sidebar">
        <div class="dashboard-main-col">
            <div class="dashboard-chart-card" style="padding-bottom: 20px;">
                <h3 class="chart-header">Peta / Visual Lokasi Pembangunan</h3>
                <div id="map2" class="dashboard-map"></div>
            </div>
        </div>
        <div class="dashboard-sidebar-col">
            <div class="summary-widget">
                <h3 class="summary-widget-title">Informasi Terbaru</h3>
                <div>
                    @foreach ($infoTerbaru as $info)
                        <div class="pub-info-item">
                            <div class="pub-info-header">
                                <p class="pub-info-title">{{ $info['judul'] }}</p>
                                <span class="status-badge {{ $info['status'] === 'Draft' ? 'warning' : 'success' }}">{{ $info['status'] }}</span>
                            </div>
                            <p class="pub-info-meta">{{ $info['kategori'] }} · {{ $info['tanggal'] }}</p>
                            <a href="#" class="action-link">Lihat PDF</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-table-card">
        <div class="dashboard-table-header">
            <h3 class="dashboard-table-title">Tabel Ringkas Proyek Pembangunan</h3>
        </div>
        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Kode Proyek</th>
                        <th>Nama Proyek</th>
                        <th>Kategori</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Anggaran</th>
                        <th>Progres</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tabelProyek as $row)
                        <tr>
                            <td>{{ $row['kode'] }}</td>
                            <td>{{ $row['nama'] }}</td>
                            <td>{{ $row['kategori'] }}</td>
                            <td>{{ $row['kecamatan'] }}</td>
                            <td>{{ $row['kelurahan'] }}</td>
                            <td>{{ $row['anggaran'] }}</td>
                            <td>{{ $row['progres'] }}</td>
                            <td><span class="{{ $row['badge'] }} font-medium">{{ $row['status'] }}</span></td>
                            <td><a href="#" class="action-link">Lihat Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="dashboard-doc-grid">
        @foreach ($dokumentasi as $dok)
            <div class="doc-card">
                <div class="doc-placeholder">📷</div>
                <div class="doc-card-body">
                    <p class="doc-card-title">{{ $dok['judul'] }}</p>
                    <p class="doc-card-sub">{{ $dok['sub'] }}</p>
                    <a href="#" class="action-link mt-4">Lihat Dokumentasi</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('extraStyles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.page-title { font-size: 34px; font-weight: 700; color: var(--slate-900); margin-top: 16px; margin-bottom: 18px; }
.dashboard-hero.bg-yellow-light { background: linear-gradient(90deg, #FEF3C7 0%, #FFFFFF 100%); border-color: #FDE68A; }
.dashboard-doc-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; margin-top: 24px; }
.doc-card { background: var(--white); border: 1px solid var(--slate-100); border-radius: 18px; overflow: hidden; box-shadow: var(--shadow-card); }
.doc-placeholder { min-height: 160px; display: grid; place-items: center; background: #F8FAFC; color: #94A3B8; font-size: 32px; }
.doc-card-body { padding: 20px; }
.doc-card-title { font-size: 15px; font-weight: 700; color: var(--slate-900); margin: 0 0 8px; }
.doc-card-sub { font-size: 13px; color: var(--slate-500); margin: 0; line-height: 1.5; }
.dashboard-map { border-radius: 18px; overflow: hidden; border: 1px solid var(--slate-100); height: 320px; }
@media (max-width: 1024px) { .dashboard-doc-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('extraScripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const barOpts = (categories, data, color) => ({
    chart: { type: 'bar', height: 220, toolbar: { show: false } },
    plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '55%' } },
    dataLabels: { enabled: true, style: { colors: ['#334155'] }, offsetX: 20 },
    series: [{ name: 'Nilai', data }],
    xaxis: { categories, labels: { show: false } },
    colors: [color],
    grid: { show: false }
});
new ApexCharts(document.querySelector('#chartProgres'), barOpts(['Jan','Feb','Mar','Apr','Mei','Jun'], [18,29,41,57,69,74], '#2563eb')).render();
new ApexCharts(document.querySelector('#chartStatusProyek'), barOpts(['Berjalan','Selesai','Tertunda','Perlu Perhatian'], [18,9,3,2], '#f59e0b')).render();
new ApexCharts(document.querySelector('#chartRealisasi'), barOpts(['Jalan','Drainase','Gedung','Fasum','RTH'], [76,54,32,20,98], '#10b981')).render();
new ApexCharts(document.querySelector('#chartKategori'), barOpts(['Jalan & Jembatan','Drainase','Gedung Pemerintahan','Fasilitas Umum','Ruang Terbuka Hijau'], [9,7,6,6,5], '#8b5cf6')).render();
const map2 = L.map('map2').setView([-7.4797, 110.2177], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map2);
</script>
@endsection
