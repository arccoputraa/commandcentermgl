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
            <p class="stat-card-value">{{ number_format((int) ($stats['totalPenduduk'] ?? 0), 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Laki-laki</h3>
            <p class="stat-card-value">{{ number_format((int) ($stats['lakiLaki'] ?? 0), 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Perempuan</h3>
            <p class="stat-card-value">{{ number_format((int) ($stats['perempuan'] ?? 0), 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Total KK</h3>
            <p class="stat-card-value">{{ number_format((int) ($stats['totalKk'] ?? 0), 0, ',', '.') }} KK</p>
        </div>
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Wajib KTP</h3>
            <p class="stat-card-value">{{ number_format((int) ($stats['wajibKtp'] ?? 0), 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Usia Produktif</h3>
            <p class="stat-card-value">{{ number_format((int) ($stats['usiaProduktif'] ?? 0), 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Kelahiran Tahun {{ $filters['tahun'] ?? now()->year }}</h3>
            <p class="stat-card-value">{{ number_format((int) ($stats['kelahiranTahunIni'] ?? 0), 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Kematian Tahun {{ $filters['tahun'] ?? now()->year }}</h3>
            <p class="stat-card-value">{{ number_format((int) ($stats['kematianTahunIni'] ?? 0), 0, ',', '.') }} Jiwa</p>
        </div>
    </div>

    <form class="dashboard-filter-bar" method="GET" action="{{ route('layanan') }}">
        <input type="hidden" name="dept" value="kependudukan">
        <div class="filter-dropdowns">
            <select class="filter-select" name="kecamatan" id="population-kecamatan" aria-label="Pilih Kecamatan">
                <option value="">Semua Kecamatan</option>
                @foreach($kecamatanOptions as $kecamatan)
                    <option value="{{ $kecamatan }}" @selected(($filters['kecamatan'] ?? '') === $kecamatan)>{{ $kecamatan }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="kelurahan" id="population-kelurahan" aria-label="Pilih Kelurahan">
                <option value="">Semua Kelurahan</option>
                @foreach($kelurahanOptions as $kelurahan)
                    @if(empty($filters['kecamatan']) || in_array($kelurahan, $kelurahanByKecamatan[$filters['kecamatan']] ?? [], true))
                        <option value="{{ $kelurahan }}" @selected(($filters['kelurahan'] ?? '') === $kelurahan)>{{ $kelurahan }}</option>
                    @endif
                @endforeach
            </select>
            <select class="filter-select" name="tahun" aria-label="Pilih Tahun">
                <option value="">Semua Tahun</option>
                @foreach($tahunOptions as $tahun)
                    <option value="{{ $tahun }}" @selected((string) ($filters['tahun'] ?? '') === (string) $tahun)>{{ $tahun }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="agama" aria-label="Pilih Agama">
                <option value="">Semua Agama</option>
                @foreach($agamaOptions as $agama)
                    <option value="{{ $agama }}" @selected(($filters['agama'] ?? '') === $agama)>{{ $agama }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="status" aria-label="Pilih Status">
                @foreach($statusOptions as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? 'Aktif') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; gap:8px; align-items:center;">
            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            <a href="{{ route('layanan', ['dept' => 'kependudukan']) }}" class="btn btn-outline">Reset</a>
        </div>
    </form>

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
                <div class="dashboard-chart-card" style="grid-column: 1 / -1;">
                    <h3 class="chart-header">Populasi Berdasarkan Kelurahan</h3>
                    <div id="chartKelurahan" style="min-height: 380px;"></div>
                </div>
            </div>
        </div>
        <div class="dashboard-sidebar-col">
            <div class="dashboard-chart-card" style="padding-bottom: 20px;">
                <h3 class="chart-header">Peta Wilayah Kota Magelang</h3>
                <div id="map3" class="dashboard-map" style="height: 320px;"></div>
                <div style="margin: 12px 4px 0; font-size: 12px; color: #64748b;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span>Sedikit</span>
                        <span aria-hidden="true" style="height: 10px; flex: 1; border-radius: 999px; background: linear-gradient(90deg, #fee2e2, #b91c1c);"></span>
                        <span>Banyak penduduk</span>
                    </div>
                    <p style="margin: 8px 0 0;">Warna menunjukkan jumlah penduduk per kecamatan. Titik lokasi masih perkiraan dan belum menunjukkan batas administratif.</p>
                </div>
            </div>
            <div class="summary-widget" style="margin-top: 24px;">
                <h3 class="summary-widget-title">Informasi Terbaru</h3>
                <div>
                    @forelse($informasiTerbaru as $informasi)
                        <div class="pub-info-item">
                            <div class="pub-info-header">
                                <p class="pub-info-title">{{ $informasi->judul }}</p>
                                <span class="status-badge success">{{ $informasi->status }}</span>
                            </div>
                            <p class="pub-info-meta">{{ $informasi->kategori }} · {{ $informasi->tanggal ? \Illuminate\Support\Carbon::parse($informasi->tanggal)->format('d/m/Y') : '-' }}</p>
                            @if($informasi->file)
                                <a href="{{ route('kependudukan.informasi-terbaru.pdf', $informasi->id) }}" target="_blank" rel="noopener" class="action-link">Lihat PDF</a>
                            @endif
                        </div>
                    @empty
                        <p class="pub-info-meta">Belum ada informasi yang dirilis.</p>
                    @endforelse
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
                        <th>Agama</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filteredPenduduk as $row)
                        <tr>
                            <td>{{ $row->tahun }}</td>
                            <td>{{ $row->kecamatan }}</td>
                            <td>{{ $row->kelurahan }}</td>
                            <td>{{ number_format((int) $row->penduduk, 0, ',', '.') }}</td>
                            <td>{{ number_format((int) $row->kk, 0, ',', '.') }} KK</td>
                            <td>{{ $row->agama }}</td>
                            <td><span class="table-badge {{ $row->status === 'Aktif' ? 'success' : 'warning' }}">{{ $row->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color:#94A3B8;">Tidak ada data untuk filter yang dipilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($filteredPenduduk->hasPages())
            <div class="dashboard-table-footer">{{ $filteredPenduduk->links() }}</div>
        @endif
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
    labels: labels ?? [],
    series: series ? series.map(Number) : [],
    colors: colors,
    noData: { text: 'Belum ada data' },
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

new ApexCharts(document.querySelector('#chartAgama'), pieOpts(
    {{ Illuminate\Support\Js::from($chartAgamaLabels ?? ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']) }},
    {{ Illuminate\Support\Js::from($chartAgamaData ?? [0, 0, 0, 0, 0, 0]) }},
    ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4']
)).render();

new ApexCharts(document.querySelector('#chartGender'), pieOpts(
    {{ Illuminate\Support\Js::from($chartGenderLabels ?? ['Laki-laki', 'Perempuan']) }},
    {{ Illuminate\Support\Js::from($chartGenderData ?? [0, 0]) }},
    ['#3b82f6', '#ec4899']
)).render();

new ApexCharts(document.querySelector('#chartKecamatan'), pieOpts(
    {{ Illuminate\Support\Js::from($chartKecamatanLabels ?? []) }},
    {{ Illuminate\Support\Js::from($chartKecamatanData ?? []) }},
    ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4']
)).render();

const pieKelurahanOpts = (labels, series) => ({
    chart: { type: 'donut', height: 350 },
    labels: labels ?? [],
    series: series ? series.map(Number) : [],
    noData: { text: 'Belum ada data' },
    theme: { palette: 'palette1' },
    legend: {
        position: 'right',
        fontSize: '11px',
        height: 330,
        width: 180,
        markers: { radius: 12 },
        formatter: function(seriesName, opts) {
            return seriesName + ' (' + opts.w.globals.series[opts.seriesIndex].toLocaleString('id-ID') + ')';
        }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '55%',
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
    dataLabels: { enabled: false },
    tooltip: {
        y: {
            formatter: function(val) {
                return val.toLocaleString('id-ID') + ' jiwa';
            }
        }
    }
});

new ApexCharts(document.querySelector('#chartKelurahan'), pieKelurahanOpts(
    {{ Illuminate\Support\Js::from($chartKelurahanLabels ?? []) }},
    {{ Illuminate\Support\Js::from($chartKelurahanData ?? []) }}
)).render();

const populationKecamatan = document.querySelector('#population-kecamatan');
const populationKelurahan = document.querySelector('#population-kelurahan');
const kelurahanByKecamatan = {{ Illuminate\Support\Js::from($kelurahanByKecamatan) }};
const selectedKelurahan = {{ Illuminate\Support\Js::from($filters['kelurahan'] ?? '') }};

populationKecamatan.addEventListener('change', () => {
    const availableKelurahan = populationKecamatan.value
        ? kelurahanByKecamatan[populationKecamatan.value] ?? []
        : Object.values(kelurahanByKecamatan).flat();
    const uniqueKelurahan = [...new Set(availableKelurahan)];

    populationKelurahan.replaceChildren(new Option('Semua Kelurahan', ''));
    uniqueKelurahan.forEach(kelurahan => {
        populationKelurahan.add(new Option(kelurahan, kelurahan));
    });
});

if (selectedKelurahan) {
    populationKelurahan.value = selectedKelurahan;
}

const map3 = L.map('map3').setView([-7.4797, 110.2177], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map3);

const kecamatanLocations = {
    'Magelang Utara': [-7.4625, 110.2200],
    'Magelang Tengah': [-7.4785, 110.2175],
    'Magelang Selatan': [-7.4945, 110.2160]
};
const kecamatanLabels = {{ Illuminate\Support\Js::from($chartKecamatanLabels ?? []) }};
const kecamatanTotals = {{ Illuminate\Support\Js::from($chartKecamatanData ?? []) }};
const kecamatanValues = kecamatanLabels
    .map((label, index) => ({ label, total: Number(kecamatanTotals[index]) }))
    .filter(({ label, total }) => kecamatanLocations[label] && Number.isFinite(total));
const minPopulation = Math.min(...kecamatanValues.map(({ total }) => total));
const maxPopulation = Math.max(...kecamatanValues.map(({ total }) => total));
const lowColor = [254, 226, 226];
const highColor = [185, 28, 28];

function populationColor(total) {
    const range = maxPopulation - minPopulation;
    const intensity = range > 0 ? (total - minPopulation) / range : 0.5;
    const color = lowColor.map((channel, index) => Math.round(channel + (highColor[index] - channel) * intensity));
    return `rgb(${color.join(',')})`;
}

function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, character => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[character]);
}

kecamatanValues.forEach(({ label, total }) => {
    L.circleMarker(kecamatanLocations[label], {
        radius: 18,
        color: '#ffffff',
        weight: 2,
        fillColor: populationColor(total),
        fillOpacity: 0.85
    })
        .bindTooltip(`${escapeHtml(label)}<br>${total.toLocaleString('id-ID')} jiwa`)
        .addTo(map3);
});
</script>
@endsection
