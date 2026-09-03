@extends('layouts.app')

@section('title', 'Kependudukan - Command Center Kota Magelang')

@section('content')
<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Kependudukan</span>
    </div>

    <div class="dashboard-hero bg-purple-light">
        <h1 class="dashboard-hero-title">Pusat Data Kependudukan</h1>
        <p class="dashboard-hero-desc">Informasi publik dan statistik sektoral kependudukan Kota Magelang.</p>
    </div>

    <div class="dashboard-stats-grid" style="grid-template-columns: repeat(4, 1fr);">
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Total Penduduk</h3>
            <p class="stat-card-value">126.840 Jiwa</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Laki-laki</h3>
            <p class="stat-card-value">62.410 Jiwa</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Perempuan</h3>
            <p class="stat-card-value">64.430 Jiwa</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Total KK</h3>
            <p class="stat-card-value">39.520 KK</p>
        </div>
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Wajib KTP</h3>
            <p class="stat-card-value">94.780 Jiwa</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Usia Produktif</h3>
            <p class="stat-card-value">86.240 Jiwa</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Kelahiran Tahun Ini</h3>
            <p class="stat-card-value">412 Jiwa</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Kematian Tahun Ini</h3>
            <p class="stat-card-value">185 Jiwa</p>
        </div>
    </div>

    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select class="filter-select"><option value="">Pilih Kecamatan</option></select>
            <select class="filter-select"><option value="">Pilih Kelurahan</option></select>
            <select class="filter-select"><option value="">Pilih Tahun</option></select>
            <select class="filter-select"><option value="">Pilih Agama</option></select>
            <select class="filter-select"><option value="">Pilih Status</option></select>
        </div>
        <button type="button" class="btn btn-primary">Terapkan Filter</button>
    </div>

    <div class="dashboard-layout-sidebar">
        <div class="dashboard-main-col">
            <div class="dashboard-charts-grid" style="margin-top: 0;">
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Populasi Berdasarkan Agama</h3>
                    <div id="chartAgama" style="min-height: 250px;"></div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Populasi Berdasarkan Jenis Kelamin</h3>
                    <div id="chartGender" style="min-height: 250px;"></div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Populasi Berdasarkan Kecamatan</h3>
                    <div id="chartKecamatan" style="min-height: 250px;"></div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Indikator Pertumbuhan Penduduk (Kelahiran &amp; Kematian)</h3>
                    <div id="chartPertumbuhan" style="min-height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="dashboard-sidebar-col">
            <div class="dashboard-chart-card" style="padding-bottom: 20px;">
                <h3 class="chart-header">Peta Wilayah Kota Magelang</h3>
                <div id="map3" class="dashboard-map" style="height: 320px;"></div>
            </div>
            <div class="summary-widget" style="margin-top: 24px;">
                <h3 class="summary-widget-title">Informasi Terbaru</h3>
                <div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Rekap Data Kependudukan Semester I 2026</p>
                            <span class="status-badge success">Rilis</span>
                        </div>
                        <p class="pub-info-meta">Rekap Penduduk · 03 Jul 2026</p>
                        <a href="/sample-document.pdf" target="_blank" class="action-link">Lihat PDF</a>
                    </div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Statistik Pemeluk Agama 2026</p>
                            <span class="status-badge success">Rilis</span>
                        </div>
                        <p class="pub-info-meta">Data Agama · 02 Jul 2026</p>
                        <a href="/sample-document.pdf" target="_blank" class="action-link">Lihat PDF</a>
                    </div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Laporan Mutasi Penduduk Juni 2026</p>
                            <span class="status-badge success">Rilis</span>
                        </div>
                        <p class="pub-info-meta">Mutasi Penduduk · 01 Jul 2026</p>
                        <a href="/sample-document.pdf" target="_blank" class="action-link">Lihat PDF</a>
                    </div>
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">Publikasi Penduduk Berdasarkan Wilayah</p>
                            <span class="status-badge warning">Draft</span>
                        </div>
                        <p class="pub-info-meta">Statistik Wilayah · 30 Jun 2026</p>
                        <a href="/sample-document.pdf" target="_blank" class="action-link">Lihat PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-table-card">
        <div class="dashboard-table-header">
            <h3 class="dashboard-table-title">Tabel Data Kependudukan</h3>
        </div>
        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Jumlah Penduduk</th>
                        <th>Jumlah KK</th>
                        <th>Agama Mayoritas</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2026</td>
                        <td>Magelang Tengah</td>
                        <td>Panjang</td>
                        <td>8.240</td>
                        <td>2.340 KK</td>
                        <td>Islam</td>
                        <td><span class="table-badge success">Aktif</span></td>
                        <td><a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td>2026</td>
                        <td>Magelang Selatan</td>
                        <td>Jurangombo Utara</td>
                        <td>7.850</td>
                        <td>2.180 KK</td>
                        <td>Islam</td>
                        <td><span class="table-badge success">Aktif</span></td>
                        <td><a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td>2026</td>
                        <td>Magelang Utara</td>
                        <td>Kedungsari</td>
                        <td>6.730</td>
                        <td>1.920 KK</td>
                        <td>Islam</td>
                        <td><span class="table-badge success">Aktif</span></td>
                        <td><a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td>2026</td>
                        <td>Magelang Tengah</td>
                        <td>Kemirirejo</td>
                        <td>5.980</td>
                        <td>1.710 KK</td>
                        <td>Islam</td>
                        <td><span class="table-badge success">Aktif</span></td>
                        <td><a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a></td>
                    </tr>
                    <tr>
                        <td>2026</td>
                        <td>Magelang Selatan</td>
                        <td>Tidar Selatan</td>
                        <td>6.410</td>
                        <td>1.860 KK</td>
                        <td>Islam</td>
                        <td><span class="table-badge success">Aktif</span></td>
                        <td><a href="#" onclick="window.showDummyDetail(this); return false;" class="action-link">Lihat Detail</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('extraStyles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('extraScripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const pieOpts = (labels, series, colors) => ({
    chart: { type: 'donut', height: 260 },
    labels: labels,
    series: series.map(Number),
    colors: colors,
    legend: { position: 'bottom', fontSize: '12px', markers: { radius: 12 } },
    plotOptions: {
        pie: {
            donut: {
                size: '60%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        fontSize: '13px',
                        fontWeight: 600,
                        color: '#64748b',
                        formatter: function (w) {
                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    },
    dataLabels: { enabled: false }
});

const barPertumbuhanOpts = (categories, kelahiran, kematian) => ({
    chart: { type: 'bar', height: 260, toolbar: { show: false } },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '45%',
            borderRadius: 4
        }
    },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ['transparent'] },
    series: [
        { name: 'Kelahiran', data: kelahiran },
        { name: 'Kematian', data: kematian }
    ],
    xaxis: { categories: categories },
    yaxis: { title: { text: 'Jiwa', style: { fontSize: '12px', color: '#64748b' } } },
    fill: { opacity: 1 },
    colors: ['#10b981', '#ef4444'],
    legend: { position: 'bottom', fontSize: '12px' },
    grid: { borderColor: '#f1f5f9' }
});

new ApexCharts(document.querySelector('#chartAgama'), pieOpts(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'], [68240,11200,9800,1420,500,280], ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'])).render();
new ApexCharts(document.querySelector('#chartGender'), pieOpts(['Laki-laki','Perempuan'], [62410,64430], ['#3b82f6', '#ec4899'])).render();
new ApexCharts(document.querySelector('#chartKecamatan'), pieOpts(['Magelang Tengah','Magelang Selatan','Magelang Utara'], [43620,42160,40895], ['#3b82f6', '#10b981', '#f59e0b'])).render();
new ApexCharts(document.querySelector('#chartPertumbuhan'), barPertumbuhanOpts(['2023', '2024', '2025', '2026'], [1250, 1340, 1420, 1180], [850, 890, 910, 760])).render();

const map3 = L.map('map3').setView([-7.4797, 110.2177], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map3);
</script>
@endsection

