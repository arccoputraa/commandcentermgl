@extends('layouts.kependudukan')

@section('title', 'Dashboard Kependudukan')

@section('content')
<style>
    .kependudukan-header { margin-bottom:40px; font-family:'Inter', sans-serif; }
    .kependudukan-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .kependudukan-header p { font-size:20px; color:#708098; margin:0; }
    .filter-card { display:grid; grid-template-columns:repeat(4, 1fr) 180px; gap:14px; padding:20px; margin-bottom:36px; background:#fff; border:1px solid #e5e7eb; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.12); }
    .filter-card select { height:48px; border:1px solid #e5e7eb; border-radius:11px; background:#fff; color:transparent; outline:none; }
    .filter-card button { height:48px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:600; cursor:pointer; }
    .metrics-grid { display:grid; grid-template-columns:repeat(4, 1fr); gap:22px; margin-bottom:16px; font-family:'Inter', sans-serif; }
    .metric-card { background:#fff; border-radius:16px; padding:28px 30px; min-height:92px; border:1px solid #e8edf3; box-shadow:0 2px 5px rgba(15,23,42,.12); display:flex; align-items:center; }
    .metric-content { flex-grow:1; }
    .metric-label { color:#708098; margin:0 0 14px 0; text-transform:uppercase; font-size:15px; font-weight:700; letter-spacing:.7px; }
    .metric-value { font-size:32px; line-height:1; font-weight:700; color:#1d293d; margin:0; }
    .panel-grid { display:grid; grid-template-columns:1fr 1fr; gap:34px; margin-top:38px; }
    .panel-card { background:#fff; border-radius:16px; border:1px solid #e8edf3; padding:32px; box-shadow:0 1px 3px rgba(15,23,42,.08); min-height:330px; }
    .panel-title { margin:0 0 30px 0; font-size:19px; font-weight:800; color:#1d293d; text-transform:uppercase; letter-spacing:.7px; }
    .bar-list { display:flex; flex-direction:column; gap:20px; }
    .bar-label { display:flex; justify-content:space-between; font-size:16px; font-weight:500; color:#45556c; margin-bottom:8px; }
    .bar-track { width:100%; height:12px; background:#f1f5f9; border-radius:999px; overflow:hidden; }
    .bar-fill { height:100%; border-radius:999px; }
    .content-grid { display:grid; grid-template-columns:1.3fr .7fr; gap:16px; margin-top:24px; }
    .table-wrap { overflow-x:auto; }
    .data-table { width:100%; border-collapse:collapse; font-size:13px; }
    .data-table th { text-align:left; color:#64748b; font-size:11px; text-transform:uppercase; letter-spacing:.5px; padding:12px; border-bottom:1px solid #e2e8f0; }
    .data-table td { padding:14px 12px; border-bottom:1px solid #f1f5f9; color:#334155; }
    .status-badge { display:inline-flex; align-items:center; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .status-badge.success { background:#dcfce7; color:#166534; }
    .status-badge.warning { background:#fef3c7; color:#92400e; }
    .info-list { display:flex; flex-direction:column; gap:12px; }
    .info-item { padding:12px; border:1px solid #e2e8f0; border-radius:8px; }
    .info-title { font-size:14px; font-weight:600; color:#1e293b; margin:0 0 6px 0; }
    .info-meta { font-size:12px; color:#64748b; margin:0; }
    @media (max-width:1100px) { .metrics-grid, .panel-grid, .content-grid, .filter-card { grid-template-columns:1fr 1fr; } }
    @media (max-width:760px) { .metrics-grid, .panel-grid, .content-grid, .filter-card { grid-template-columns:1fr; } }
</style>

<div class="kependudukan-header">
    <h2>Dashboard Kependudukan</h2>
    <p>Pantau ringkasan penduduk, agama, wilayah, kartu keluarga, dan mutasi penduduk.</p>
</div>

<form class="filter-card" action="#" method="GET">
    <select aria-label="Pilih Kecamatan"><option value="">Pilih Kecamatan</option></select>
    <select aria-label="Pilih Kelurahan"><option value="">Pilih Kelurahan</option></select>
    <select aria-label="Pilih Tahun"><option value="">Pilih Tahun</option></select>
    <select aria-label="Pilih Agama"><option value="">Pilih Agama</option></select>
    <button type="button">Terapkan Filter</button>
</form>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Total Penduduk</p><p class="metric-value">{{ number_format($stats['totalPenduduk'], 0, ',', '.') }} Jiwa</p></div>
    </div>
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Laki-laki</p><p class="metric-value">{{ number_format($stats['lakiLaki'], 0, ',', '.') }} Jiwa</p></div>
    </div>
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Perempuan</p><p class="metric-value">{{ number_format($stats['perempuan'], 0, ',', '.') }} Jiwa</p></div>
    </div>
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Total KK</p><p class="metric-value">{{ number_format($stats['totalKk'], 0, ',', '.') }} KK</p></div>
    </div>
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Wajib KTP</p><p class="metric-value">{{ number_format($stats['wajibKtp'], 0, ',', '.') }} Jiwa</p></div>
    </div>
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Usia Produktif</p><p class="metric-value">{{ number_format($stats['usiaProduktif'], 0, ',', '.') }} Jiwa</p></div>
    </div>
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Kelahiran Tahun Ini</p><p class="metric-value">{{ number_format($stats['kelahiranTahunIni'], 0, ',', '.') }} Jiwa</p></div>
    </div>
    <div class="metric-card">
        <div class="metric-content"><p class="metric-label">Kematian Tahun Ini</p><p class="metric-value">{{ number_format($stats['kematianTahunIni'], 0, ',', '.') }} Jiwa</p></div>
    </div>
</div>

<div class="panel-grid">
    <div class="panel-card">
        <h3 class="panel-title">Populasi Berdasarkan Agama</h3>
        <div id="chartAgama" style="min-height: 250px;"></div>
    </div>

    <div class="panel-card">
        <h3 class="panel-title">Populasi Berdasarkan Jenis Kelamin</h3>
        <div id="chartGender" style="min-height: 250px;"></div>
    </div>
    
    <div class="panel-card" style="grid-column: 1 / -1;">
        <h3 class="panel-title">Populasi Berdasarkan Kelurahan</h3>
        <div id="chartKelurahan" style="min-height: 400px;"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pieOpts = (labels, series, colors) => ({
            chart: { type: 'donut', height: 260 },
            labels: labels && labels.length > 0 ? labels : ['Data Kosong'],
            series: series && series.length > 0 ? series.map(Number) : [1],
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
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    return val.toFixed(1) + "%"; 
                }
            },
            tooltip: {
                y: { formatter: function(val) { return val.toLocaleString('id-ID') + " jiwa"; } }
            }
        });

        const barOpts = (labels, series, colors) => ({
            chart: { type: 'bar', height: 400, toolbar: { show: false }, stacked: true },
            series: [
                { name: 'Populasi', data: series && series.length > 0 ? series.map(Number) : [0] },
                { name: 'Dummy', data: series && series.length > 0 ? series.map(() => 0) : [0] }
            ],
            colors: ['#2563eb', 'transparent'],
            plotOptions: {
                bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' } }
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [1],
                offsetX: 40,
                style: { fontSize: '12px', colors: ['#333'] },
                formatter: function (val, opts) {
                    let realVal = opts.w.config.series[0].data[opts.dataPointIndex];
                    return realVal.toLocaleString('id-ID');
                }
            },
            stroke: { width: 1, colors: ['#fff'] },
            xaxis: {
                categories: labels && labels.length > 0 ? labels : ['Kosong'],
                labels: { formatter: function (val) { return val.toLocaleString('id-ID'); } }
            },
            yaxis: { title: { text: undefined } },
            tooltip: {
                y: { formatter: function (val, opts) {
                    if (opts.seriesIndex === 1) return undefined;
                    return val.toLocaleString('id-ID') + " jiwa";
                }}
            },
            legend: { show: false }
        });

        // Data Agama
        const agamaData = {!! json_encode($agama) !!};
        new ApexCharts(document.querySelector('#chartAgama'), pieOpts(
            agamaData.map(d => d.label),
            agamaData.map(d => d.total),
            ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899']
        )).render();

        // Data Gender
        const genderData = {
            laki: {{ $stats['lakiLaki'] }},
            perempuan: {{ $stats['perempuan'] }}
        };
        new ApexCharts(document.querySelector('#chartGender'), pieOpts(
            ['Laki-laki', 'Perempuan'],
            [genderData.laki, genderData.perempuan],
            ['#3b82f6', '#ec4899']
        )).render();

        // Data Kelurahan
        const kelurahanChartData = {!! json_encode($kelurahanChart ?? []) !!};
        new ApexCharts(document.querySelector('#chartKelurahan'), barOpts(
            kelurahanChartData.map(d => d.label),
            kelurahanChartData.map(d => d.total),
            ['#2563eb']
        )).render();
    });
</script>

<div class="content-grid">
    <div class="panel-card">
        <h3 class="panel-title">Tabel Data Kependudukan</h3>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Jumlah Penduduk</th>
                        <th>Jumlah KK</th>
                        <th>Agama Mayoritas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelurahan as $row)
                        <tr>
                            <td>{{ $row['tahun'] }}</td>
                            <td>{{ $row['kecamatan'] }}</td>
                            <td>{{ $row['kelurahan'] }}</td>
                            <td>{{ number_format($row['penduduk'], 0, ',', '.') }}</td>
                            <td>{{ number_format($row['kk'], 0, ',', '.') }} KK</td>
                            <td>{{ $row['agama'] }}</td>
                            <td><span class="status-badge success">Aktif</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel-card">
        <h3 class="panel-title">Informasi Terbaru</h3>
        <div class="info-list">
            @foreach($publikasi as $item)
                <div class="info-item">
                    <div style="display:flex; justify-content:space-between; gap:12px; align-items:flex-start;">
                        <p class="info-title">{{ $item['judul'] }}</p>
                        <span class="status-badge {{ $item['status'] === 'Rilis' ? 'success' : 'warning' }}">{{ $item['status'] }}</span>
                    </div>
                    <p class="info-meta">{{ $item['kategori'] }} - {{ $item['tanggal'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
