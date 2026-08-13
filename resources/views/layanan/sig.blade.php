@extends('layouts.app')

@section('title', 'SIG - Command Center Kota Magelang')

@section('content')
@php
$statsSIG = [
    ['label' => 'RUMAH SANITASI', 'value' => '15'],
    ['label' => 'SUMUR RESAPAN', 'value' => '15'],
    ['label' => 'WIFI', 'value' => '15'],
    ['label' => 'RUANG TERBUKA HIJAU', 'value' => '15'],
    ['label' => 'UMKM', 'value' => '15'],
    ['label' => 'CCTV', 'value' => '15'],
];

$layerPublik = [
    'Mata Air', 'Kemiskinan', 'Bahaya Banjir', 'Distribusi Pangan', 'Bahaya Genangan', 'Distribusi Sanitasi', 'Kerentanan Pangan', 'Volume to Capacity Ratio', 'Batas Wilayah Administrasi'
];

$tabelSIG = [
    ['nama_data' => 'Sanitasi Tidar Selatan 01', 'kategori' => 'Rumah Sanitasi', 'wilayah' => 'Tidar Selatan', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '03 Jul 2026'],
    ['nama_data' => 'Sumur Resapan Panjang 02', 'kategori' => 'Sumur Resapan', 'wilayah' => 'Panjang', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '03 Jul 2026'],
    ['nama_data' => 'WIFI Alun-Alun Kota', 'kategori' => 'WIFI', 'wilayah' => 'Kemirirejo', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '02 Jul 2026'],
    ['nama_data' => 'Taman Kedungsari Hijau', 'kategori' => 'Ruang Terbuka Hijau', 'wilayah' => 'Kedungsari', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '02 Jul 2026'],
    ['nama_data' => 'Sentra UMKM Rejowinangun', 'kategori' => 'UMKM', 'wilayah' => 'Rejowinangun', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '01 Jul 2026'],
    ['nama_data' => 'CCTV Simpang Trio', 'kategori' => 'CCTV', 'wilayah' => 'Panjang', 'nilai_jumlah' => '1 Titik', 'update_terakhir' => '01 Jul 2026'],
];

$infoTerbaruSIG = [
    ['judul' => 'Laporan SIG Kota Semester I 2026', 'kategori' => 'Laporan SIG', 'tanggal' => '03 Jul 2026', 'status' => 'Rilis', 'badge' => 'success'],
    ['judul' => 'Peta Tematik Sanitasi Kota', 'kategori' => 'Peta Tematik', 'tanggal' => '02 Jul 2026', 'status' => 'Rilis', 'badge' => 'success'],
    ['judul' => 'Analisis Kerentanan Pangan 2026', 'kategori' => 'Analisis Spasial', 'tanggal' => '01 Jul 2026', 'status' => 'Draft', 'badge' => 'warning'],
    ['judul' => 'Publikasi Titik CCTV Kota', 'kategori' => 'Publikasi Fasilitas Kota', 'tanggal' => '30 Jun 2026', 'status' => 'Rilis', 'badge' => 'success'],
];
@endphp

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data SIG</span>
    </div>

    <div class="dashboard-hero bg-green-light">
        <h1 class="dashboard-hero-title">Pusat Data SIG</h1>
        <p class="dashboard-hero-desc">Informasi publik dan statistik spasial Kota Magelang.</p>
    </div>

    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select><option>Kecamatan</option></select>
            <select><option>Kategori</option></select>
            <select><option>Tahun</option></select>
            <input type="text" placeholder="Search indikator" />
        </div>
        <button class="btn btn-primary">Terapkan Filter</button>
    </div>

    <div class="dashboard-layout-sidebar sig-map-layout">
        <div class="dashboard-sidebar-col">
            <div class="dashboard-chart-card" style="padding-bottom: 20px;">
                <h3 class="chart-header">Layer Publik</h3>
                <div class="layer-list">
                    @foreach ($layerPublik as $index => $layer)
                        <button type="button" class="layer-list-button {{ $index === 0 ? 'active' : '' }}">{{ $layer }}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="dashboard-main-col">
            <div class="dashboard-chart-card" style="padding-bottom: 20px;">
                <div class="dashboard-chart-toolbar">
                    <h3 class="chart-header" style="margin-bottom:0;">Peta Utama: Mata Air</h3>
                    <span class="status-badge success" style="font-size:11px; padding:5px 10px;">Layer Aktif</span>
                </div>
                <div id="map" class="dashboard-map" style="height: 360px;"></div>
            </div>
        </div>
    </div>

    <div class="dashboard-stats-grid" style="margin-top: 24px; grid-template-columns: repeat(6, minmax(0, 1fr));">
        @foreach ($statsSIG as $stat)
            <div class="stat-card">
                <h3 class="stat-card-title">{{ $stat['label'] }}</h3>
                <p class="stat-card-value">{{ $stat['value'] }}</p>
                <a href="#" onclick="alert('Fitur sedang dalam pengembangan.'); return false;" class="action-link stat-action-link">Lihat Data</a>
            </div>
        @endforeach
    </div>

    <div class="dashboard-layout-sidebar" style="grid-template-columns: 2fr 1fr; gap: 24px; margin-top: 24px;">
        <div>
            <div class="dashboard-table-card">
                <div class="dashboard-table-header">
                    <h3 class="dashboard-table-title">Tabel Data SIG Publik</h3>
                </div>
                <div class="dashboard-table-wrap">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Nama Data</th>
                                <th>Kategori</th>
                                <th>Wilayah</th>
                                <th>Nilai / Jumlah</th>
                                <th>Update Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tabelSIG as $row)
                                <tr>
                                    <td>{{ $row['nama_data'] }}</td>
                                    <td>{{ $row['kategori'] }}</td>
                                    <td>{{ $row['wilayah'] }}</td>
                                    <td>{{ $row['nilai_jumlah'] }}</td>
                                    <td>{{ $row['update_terakhir'] }}</td>
                                    <td><a href="#" onclick="alert('Fitur sedang dalam pengembangan.'); return false;" class="action-link">Lihat Detail</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
            <div class="summary-widget">
                <h3 class="summary-widget-title">Informasi Terbaru</h3>
                <div>
                    @foreach ($infoTerbaruSIG as $info)
                        <div class="pub-info-item">
                            <div class="pub-info-header">
                                <p class="pub-info-title">{{ $info['judul'] }}</p>
                                <span class="status-badge {{ $info['badge'] === 'warning' ? 'warning' : 'success' }}">{{ $info['status'] }}</span>
                            </div>
                            <p class="pub-info-meta">{{ $info['kategori'] }} · {{ $info['tanggal'] }}</p>
                            <a href="#" onclick="alert('Fitur sedang dalam pengembangan.'); return false;" class="action-link">Lihat PDF</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraStyles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.sig-map-layout { grid-template-columns: 1fr 2fr; }
.layer-list {
    display: grid;
    gap: 12px;
}
.layer-list-button {
    width: 100%;
    text-align: left;
    padding: 14px 16px;
    border: 1px solid var(--slate-200);
    border-radius: 16px;
    background: #F8FAFC;
    color: var(--slate-700);
    font-size: 14px;
    font-weight: 600;
    transition: border-color .2s ease, background .2s ease, color .2s ease;
}
.layer-list-button.active {
    background: var(--blue);
    color: #fff;
    border-color: var(--blue);
}
.dashboard-chart-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 24px;
}
.stat-action-link {
    margin-top: 18px;
    display: inline-flex;
}
@media (max-width: 1024px) {
    .sig-map-layout { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('extraScripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([-7.4797, 110.2177], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
L.marker([-7.4797, 110.2177]).addTo(map).bindPopup('Mata Air Kota Magelang');
</script>
@endsection
