@extends('layouts.app')

@section('title', 'Perhubungan - Command Center Kota Magelang')

@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Perhubungan</span>
    </div>

    <div class="dashboard-hero bg-blue-light">
        <h1 class="dashboard-hero-title">Pusat Data Perhubungan</h1>
        <p class="dashboard-hero-desc">Informasi publik dan statistik sektoral perhubungan Kota Magelang.</p>
    </div>

    <div class="dashboard-stats-grid" style="margin-top: 24px; grid-template-columns: repeat(4, minmax(0, 1fr));">
        @foreach ($statsPerhubungan as $stat)
            <div class="stat-card">
                <h3 class="stat-card-title">{{ $stat['label'] }}</h3>
                <p class="stat-card-value">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select><option>Jenis Kendaraan</option></select>
            <select><option>Status Uji</option></select>
            <select><option>Bulan</option></select>
        </div>
        <div class="filter-search" style="flex:1; min-width:220px;">
            <input type="text" placeholder="Search kendaraan / indikator" />
        </div>
        <button class="btn btn-primary">Terapkan Filter</button>
    </div>

    <div class="dashboard-layout-sidebar">
        <div class="dashboard-main-col">
            <div class="dashboard-charts-grid" style="margin-top: 0;">
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Komposisi Jenis Kendaraan</h3>
                    <div id="chartKomposisi" style="min-height: 250px;"></div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Tren KIR Kendaraan per Bulan</h3>
                    <div id="chartTren" style="min-height: 250px;"></div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Status Hasil Uji KIR</h3>
                    <div id="chartStatusUji" style="min-height: 250px;"></div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">KIR Berdasarkan Jenis Kendaraan</h3>
                    <div id="chartKIRJenis" style="min-height: 250px;"></div>
                </div>
                <div class="dashboard-chart-card" style="grid-column: span 2;">
                    <h3 class="chart-header">Layanan KIR Berdasarkan Unit</h3>
                    <div id="chartLayananUnit" style="min-height: 250px;"></div>
                </div>
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
                            <a href="/sample-document.pdf" target="_blank" class="action-link">Lihat PDF</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-table-card">
        <div class="dashboard-table-header">
            <h3 class="dashboard-table-title">Tabel Ringkas KIR Kendaraan</h3>
        </div>
        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Bulan/Tahun</th>
                        <th>Jenis Kendaraan</th>
                        <th>Total Uji KIR</th>
                        <th>Lulus Uji</th>
                        <th>Tidak Lulus</th>
                        <th>Perlu Uji Ulang</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tabelKIR as $row)
                        <tr>
                            <td>{{ $row['bulan_tahun'] }}</td>
                            <td>{{ $row['jenis_kendaraan'] }}</td>
                            <td>{{ $row['total_ukir'] }}</td>
                            <td>{{ $row['lulus_uji'] }}</td>
                            <td>{{ $row['tidak_lulus'] }}</td>
                            <td>{{ $row['perlu_uji_ulang'] }}</td>
                            <td><span class="table-badge success">{{ $row['keterangan'] }}</span></td>
                            <td><a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('extraStyles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.dashboard-hero-title { font-size: 32px; }
.dashboard-hero-desc { max-width: 660px; }
.dashboard-chart-card[style*='grid-column: span 2'] { grid-column: span 2; }
@media (max-width: 1024px) { .dashboard-chart-card[style*='grid-column: span 2'] { grid-column: span 1; } }
</style>
@endsection

@section('extraScripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
const barOpts = (categories, data, color) => ({
    chart: { type: 'bar', height: 220, toolbar: { show: false } },
    plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '55%' } },
    dataLabels: { enabled: true, style: { colors: ['#334155'] }, offsetX: 20 },
    series: [{ name: 'Jumlah', data }],
    xaxis: { categories, labels: { show: false } },
    colors: [color],
    grid: { show: false }
});
new ApexCharts(document.querySelector('#chartKomposisi'), barOpts(['Barang Bak Tertutup','Truk Pengangkut','Bus Kecil','Barang Bak Besar','Penerik','Bus Sedan','Bus Besar','Motor'], [1240,1120,980,860,640,520,480,312], '#2563eb')).render();
new ApexCharts(document.querySelector('#chartTren'), barOpts(['Januari','Februari','Maret','April','Mei'], [152,148,171,160,163], '#10b981')).render();
new ApexCharts(document.querySelector('#chartStatusUji'), barOpts(['Lulus','Tidak Lulus','Perlu Uji Ulang'], [145,12,6], '#f59e0b')).render();
new ApexCharts(document.querySelector('#chartKIRJenis'), barOpts(['JN-001','JN-002','JN-003','JN-004','JN-005','JN-006'], [1240,1120,980,860,640,520], '#8b5cf6')).render();
new ApexCharts(document.querySelector('#chartLayananUnit'), barOpts(['UPT-KIR-01','POS-TIM-01','POS-BRG-01'], [6820,124,120], '#06b6d4')).render();
</script>
@endsection

