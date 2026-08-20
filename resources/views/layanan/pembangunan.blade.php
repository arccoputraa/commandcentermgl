@extends('layouts.app')

@section('title', 'Pembangunan - Command Center Kota Magelang')

@section('content')
@php
$formattedStats = [];
if(isset($stats)) {
    $formattedStats = [
        ['label' => 'Total Proyek', 'value' => $stats['total'] . ' Proyek'],
        ['label' => 'Proyek Berjalan', 'value' => $stats['berjalan'] . ' Proyek'],
        ['label' => 'Proyek Selesai', 'value' => $stats['selesai'] . ' Proyek'],
        ['label' => 'Total Anggaran', 'value' => 'Rp ' . number_format($stats['anggaran'], 0, ',', '.')],
    ];
}
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
        @foreach ($formattedStats as $stat)
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
                    @foreach ($projects->take(5) as $info)
                        <div class="pub-info-item">
                            <div class="pub-info-header">
                                <p class="pub-info-title">{{ $info->name }}</p>
                                <span class="status-badge {{ $info->status === 'Selesai' ? 'success' : 'warning' }}">{{ $info->status }}</span>
                            </div>
                            <p class="pub-info-meta">{{ $info->category }} - {{ \Carbon\Carbon::parse($info->created_at)->format('d M Y') }}</p>
                            <a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a>
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
                    @foreach ($projects as $row)
                        <tr>
                            <td>{{ $row->project_code }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->category }}</td>
                            <td>{{ $row->kecamatan ?? '-' }}</td>
                            <td>{{ $row->kelurahan ?? '-' }}</td>
                            <td>Rp {{ number_format($row->total_budget, 0, ',', '.') }}</td>
                            <td>{{ $row->progress_percentage }}%</td>
                            <td><span class="{{ $row->status === 'Selesai' ? 'text-green-600' : 'text-yellow-600' }} font-medium">{{ $row->status }}</span></td>
                            <td><a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="dashboard-doc-grid">
        @foreach ($dokumentasi as $dok)
            <div class="doc-card">
                @if($dok->file_path)
                    <div class="doc-placeholder" style="background-image: url('{{ asset($dok->file_path) }}'); background-size: cover; background-position: center; color: transparent;">??</div>
                @else
                    <div class="doc-placeholder">??</div>
                @endif
                <div class="doc-card-body">
                    <p class="doc-card-title">{{ $dok->title }}</p>
                    <p class="doc-card-sub">{{ $dok->project ? $dok->project->name : '-' }}</p>
                    <a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link mt-4">Lihat Dokumentasi</a>
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

