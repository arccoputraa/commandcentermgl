@extends('layouts.app')

@section('title', 'Kependudukan - Command Center Kota Magelang')

@section('content')
<style>
/* Detail Modal */
.kep-modal-overlay {
    display:none; position:fixed; inset:0; background:rgba(15,23,42,.55); z-index:9999;
    align-items:center; justify-content:center;
}
.kep-modal-overlay.active { display:flex; }
.kep-modal {
    background:#fff; border-radius:18px; box-shadow:0 8px 40px rgba(15,23,42,.18);
    padding:40px 44px; max-width:680px; width:94%; max-height:88vh; overflow-y:auto;
    position:relative;
}
.kep-modal-close {
    position:absolute; top:18px; right:22px; background:none; border:none;
    font-size:22px; color:#94a3b8; cursor:pointer; line-height:1;
}
.kep-modal-close:hover { color:#334155; }
.kep-modal-title { font-size:22px; font-weight:800; color:#1d293d; margin:0 0 6px 0; }
.kep-modal-sub { font-size:15px; color:#94a3b8; margin:0 0 28px 0; }
.kep-modal-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px 40px; }
.kep-modal-item label { display:block; font-size:13px; color:#708098; font-weight:700; margin-bottom:4px; text-transform:uppercase; letter-spacing:.04em; }
.kep-modal-item p { font-size:17px; font-weight:700; color:#1d293d; margin:0; }
.kep-modal-badge { display:inline-block; padding:4px 14px; border-radius:999px; font-size:13px; font-weight:800; }
.kep-modal-badge.aktif { background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; }
.kep-modal-badge.nonaktif { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
.kep-modal-divider { grid-column:1/-1; border:none; border-top:1px solid #e5e7eb; margin:4px 0; }
.kep-modal-history { grid-column:1/-1; margin-top:8px; }
.kep-modal-history h4 { font-size:17px; font-weight:800; color:#1d293d; margin:0 0 12px 0; }
.kep-modal-history p { font-size:14px; color:#53657d; margin:0 0 8px 0; }
@media (max-width:600px) { .kep-modal { padding:26px 18px; } .kep-modal-grid { grid-template-columns:1fr; } }
</style>

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
            <p class="stat-card-value">{{ number_format($stats['totalPenduduk'], 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Laki-laki</h3>
            <p class="stat-card-value">{{ number_format($stats['lakiLaki'], 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Perempuan</h3>
            <p class="stat-card-value">{{ number_format($stats['perempuan'], 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Total KK</h3>
            <p class="stat-card-value">{{ number_format($stats['totalKk'], 0, ',', '.') }} KK</p>
        </div>
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Wajib KTP</h3>
            <p class="stat-card-value">{{ number_format($stats['wajibKtp'], 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">Usia Produktif</h3>
            <p class="stat-card-value">{{ number_format($stats['usiaProduktif'], 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Kelahiran Tahun Ini</h3>
            <p class="stat-card-value">{{ number_format($stats['kelahiranTahunIni'], 0, ',', '.') }} Jiwa</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">Kematian Tahun Ini</h3>
            <p class="stat-card-value">{{ number_format($stats['kematianTahunIni'], 0, ',', '.') }} Jiwa</p>
        </div>
    </div>

    <form class="dashboard-filter-bar" method="GET" action="{{ route('layanan') }}">
        <input type="hidden" name="dept" value="kependudukan">
        <div class="filter-dropdowns">
            <select class="filter-select" name="kecamatan" style="color:#1d293d;">
                <option value="">Pilih Kecamatan</option>
                @foreach($kecamatanOptions as $kec)
                    <option value="{{ $kec }}" {{ ($filters['kecamatan'] ?? '') === $kec ? 'selected' : '' }}>{{ $kec }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="kelurahan" style="color:#1d293d;">
                <option value="">Pilih Kelurahan</option>
                @foreach($kelurahanOptions as $kel)
                    <option value="{{ $kel }}" {{ ($filters['kelurahan'] ?? '') === $kel ? 'selected' : '' }}>{{ $kel }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="tahun" style="color:#1d293d;">
                <option value="">Pilih Tahun</option>
                @foreach($tahunOptions as $th)
                    <option value="{{ $th }}" {{ (string) ($filters['tahun'] ?? '') === (string) $th ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="agama" style="color:#1d293d;">
                <option value="">Pilih Agama</option>
                @foreach($agamaOptions as $ag)
                    <option value="{{ $ag }}" {{ ($filters['agama'] ?? '') === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="status" style="color:#1d293d;">
                <option value="">Pilih Status</option>
                @foreach($statusOptions as $st)
                    <option value="{{ $st }}" {{ ($filters['status'] ?? '') === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
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
                    @forelse($informasiTerbaru as $info)
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">{{ Str::limit($info['judul'], 40) }}</p>
                            <span class="status-badge {{ $info['status'] === 'Rilis' ? 'success' : 'warning' }}">{{ $info['status'] }}</span>
                        </div>
                        <p class="pub-info-meta">{{ $info['kategori'] }} &bull; {{ $info['tanggal'] }}</p>
                        <a href="#" onclick="openInfoModal({{ json_encode($info) }}); return false;" class="action-link">Lihat Detail</a>
                    </div>
                    @empty
                    <p style="font-size:13px; color:#64748b; padding:10px 0;">Belum ada informasi terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-table-card">
        <div class="dashboard-table-header">
            <h3 class="dashboard-table-title">Tabel Data Kependudukan</h3>
            @if(!empty(array_filter($filters ?? [])))
                <span style="font-size:14px; color:#2563eb; font-weight:600;">
                    Menampilkan {{ count($filteredPenduduk) }} dari {{ count($dataPenduduk) }} data
                </span>
            @endif
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
                    @forelse($filteredPenduduk as $item)
                    <tr>
                        <td>{{ $item['tahun'] }}</td>
                        <td>{{ $item['kecamatan'] }}</td>
                        <td>{{ $item['kelurahan'] }}</td>
                        <td>{{ number_format($item['penduduk'], 0, ',', '.') }}</td>
                        <td>{{ number_format($item['kk'], 0, ',', '.') }} KK</td>
                        <td>{{ $item['agama'] }}</td>
                        <td>
                            <span class="table-badge {{ $item['status'] === 'Aktif' ? 'success' : 'danger' }}">{{ $item['status'] }}</span>
                        </td>
                        <td>
                            <a href="#" class="action-link" onclick="openDetailModal({{ json_encode($item) }}); return false;">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:20px; color:#64748b;">Tidak ada data yang sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Detail Modal untuk Tabel Penduduk --}}
<div class="kep-modal-overlay" id="modalDetailPenduduk">
    <div class="kep-modal">
        <button class="kep-modal-close" onclick="closeDetailModal()">&times;</button>
        <p class="kep-modal-title" id="modalDetailTitle">Detail Data Penduduk</p>
        <p class="kep-modal-sub">Data kependudukan publik Kota Magelang</p>
        <div class="kep-modal-grid" id="modalDetailBody"></div>
    </div>
</div>

{{-- Detail Modal untuk Informasi Terbaru --}}
<div class="kep-modal-overlay" id="modalInfoDetail">
    <div class="kep-modal">
        <button class="kep-modal-close" onclick="closeInfoModal()">&times;</button>
        <p class="kep-modal-title" id="modalInfoTitle">Detail Informasi</p>
        <p class="kep-modal-sub" id="modalInfoSub">Detail data internal untuk informasi terbaru.</p>
        <div class="kep-modal-grid" id="modalInfoBody"></div>
        <div class="kep-modal-history" id="modalInfoHistory" style="margin-top:24px; padding-top:20px; border-top:1px solid #e5e7eb;">
            <h4>Riwayat Perubahan</h4>
            <p id="modalInfoHistory1"></p>
            <p>02 Jul 2026 &middot; Data diverifikasi oleh koordinator bidang.</p>
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
// ── Charts ────────────────────────────────────────────────────────────────────
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

// Data Umum -> PIE / DONUT CHARTS
new ApexCharts(document.querySelector('#chartAgama'), pieOpts(
    {!! json_encode($chartAgamaLabels) !!},
    {!! json_encode($chartAgamaData) !!},
    ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899']
)).render();

new ApexCharts(document.querySelector('#chartGender'), pieOpts(
    {!! json_encode($chartGenderLabels) !!},
    {!! json_encode($chartGenderData) !!},
    ['#3b82f6', '#ec4899']
)).render();

new ApexCharts(document.querySelector('#chartKecamatan'), pieOpts(
    {!! json_encode($chartKecamatanLabels) !!},
    {!! json_encode($chartKecamatanData) !!},
    ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4']
)).render();

// Indikator Pertumbuhan -> BAR CHART
new ApexCharts(document.querySelector('#chartPertumbuhan'), barPertumbuhanOpts(
    {!! json_encode(!empty($chartPertumbuhanTahun) ? $chartPertumbuhanTahun : ['2023', '2024', '2025', '2026']) !!},
    {!! json_encode(!empty($chartPertumbuhanKelahiran) ? $chartPertumbuhanKelahiran : [1250, 1340, 1420, $stats['kelahiranTahunIni']]) !!},
    {!! json_encode(!empty($chartPertumbuhanKematian) ? $chartPertumbuhanKematian : [850, 890, 910, $stats['kematianTahunIni']]) !!}
)).render();

// ── Peta ─────────────────────────────────────────────────────────────────────
const map3 = L.map('map3').setView([-7.4797, 110.2177], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map3);

// ── Modal: Detail Tabel Penduduk ──────────────────────────────────────────────
function fmt(n) {
    return Number(n).toLocaleString('id-ID');
}

function openDetailModal(item) {
    document.getElementById('modalDetailTitle').textContent = item.kelurahan + ' – ' + item.kecamatan;
    const body = document.getElementById('modalDetailBody');
    body.innerHTML = `
        <div class="kep-modal-item"><label>Tahun</label><p>${item.tahun}</p></div>
        <div class="kep-modal-item"><label>Kecamatan</label><p>${item.kecamatan}</p></div>
        <div class="kep-modal-item"><label>Kelurahan</label><p>${item.kelurahan}</p></div>
        <div class="kep-modal-item"><label>Agama Mayoritas</label><p>${item.agama}</p></div>
        <hr class="kep-modal-divider">
        <div class="kep-modal-item"><label>Jumlah Penduduk</label><p>${fmt(item.penduduk)} Jiwa</p></div>
        <div class="kep-modal-item"><label>Laki-laki</label><p>${fmt(item.laki_laki)} Jiwa</p></div>
        <div class="kep-modal-item"><label>Perempuan</label><p>${fmt(item.perempuan)} Jiwa</p></div>
        <div class="kep-modal-item"><label>Jumlah KK</label><p>${fmt(item.kk)} KK</p></div>
        <div class="kep-modal-item"><label>Wajib KTP</label><p>${fmt(item.wajib_ktp)} Jiwa</p></div>
        <div class="kep-modal-item"><label>Usia Produktif</label><p>${fmt(item.usia_produktif)} Jiwa</p></div>
        <div class="kep-modal-item"><label>Anak</label><p>${fmt(item.anak)} Jiwa</p></div>
        <div class="kep-modal-item"><label>Lansia</label><p>${fmt(item.lansia)} Jiwa</p></div>
        <div class="kep-modal-item"><label>Update Terakhir</label><p>${item.update}</p></div>
        <div class="kep-modal-item"><label>Status</label>
            <p><span class="kep-modal-badge ${item.status === 'Aktif' ? 'aktif' : 'nonaktif'}">${item.status}</span></p>
        </div>
    `;
    document.getElementById('modalDetailPenduduk').classList.add('active');
}

function closeDetailModal() {
    document.getElementById('modalDetailPenduduk').classList.remove('active');
}

// ── Modal: Detail Informasi Terbaru ───────────────────────────────────────────
function openInfoModal(info) {
    document.getElementById('modalInfoTitle').textContent = info.judul;
    document.getElementById('modalInfoSub').textContent = 'Kategori: ' + info.kategori;
    document.getElementById('modalInfoBody').innerHTML = `
        <div class="kep-modal-item"><label>Judul</label><p>${info.judul}</p></div>
        <div class="kep-modal-item"><label>Kategori</label><p>${info.kategori}</p></div>
        <div class="kep-modal-item"><label>File PDF</label><p>${info.file || '-'}</p></div>
        <div class="kep-modal-item"><label>Tanggal Update</label><p>${info.tanggal}</p></div>
        <div class="kep-modal-item"><label>Status</label>
            <p><span class="kep-modal-badge ${info.status === 'Rilis' ? 'aktif' : 'nonaktif'}">${info.status}</span></p>
        </div>
    `;
    document.getElementById('modalInfoHistory1').textContent = info.tanggal + ' · Data diperbarui oleh Operator Kependudukan.';
    document.getElementById('modalInfoDetail').classList.add('active');
}

function closeInfoModal() {
    document.getElementById('modalInfoDetail').classList.remove('active');
}

// ── Tutup modal saat klik luar ────────────────────────────────────────────────
document.getElementById('modalDetailPenduduk').addEventListener('click', function(e) {
    if (e.target === this) closeDetailModal();
});
document.getElementById('modalInfoDetail').addEventListener('click', function(e) {
    if (e.target === this) closeInfoModal();
});
</script>
@endsection
