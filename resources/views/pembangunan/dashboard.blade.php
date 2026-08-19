@extends('layouts.pembangunan')

@section('title', 'Pusat Data Pembangunan')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .dashboard-header { margin-bottom: 24px; }
    .dashboard-header h1 { font-size: 24px; font-weight: 700; color: #1E293B; margin-bottom: 8px; }
    .dashboard-header p { color: #64748B; font-size: 14px; }
    
    .filter-bar { display: flex; gap: 12px; margin-bottom: 24px; background: #fff; padding: 16px; border-radius: 12px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .filter-input { padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #1E293B; flex: 1; min-width: 150px; }
    .btn-primary-custom { background: #009966; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .btn-primary-custom:hover { background: #008055; }
    
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
    .stat-card { background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; }
    .stat-info { display: flex; flex-direction: column; gap: 8px; }
    .stat-label { font-size: 11px; font-weight: 600; color: #64748B; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-value { font-size: 24px; font-weight: 700; color: #1E293B; }
    .stat-icon-wrapper { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    
    .icon-blue { background: #EFF6FF; color: #3B82F6; }
    .icon-green { background: #ECFDF5; color: #10B981; }
    .icon-red { background: #FEF2F2; color: #EF4444; }
    .icon-purple { background: #FAF5FF; color: #A855F7; }
    .icon-orange { background: #FFF7ED; color: #F97316; }
    .icon-teal { background: #F0FDFA; color: #14B8A6; }
    .icon-gray { background: #F8FAFC; color: #64748B; }

    .section-title { font-size: 18px; font-weight: 700; color: #1E293B; margin-bottom: 16px; margin-top: 32px; }
    
    .chart-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 32px; }
    .chart-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .chart-title { font-size: 14px; font-weight: 600; color: #1E293B; margin-bottom: 16px; }
    
    .map-docs-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 32px; }
    .map-card, .docs-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    #map { width: 100%; height: 350px; border-radius: 8px; background: #F1F5F9; z-index: 1; }
    
    .doc-list { list-style: none; padding: 0; margin: 0; }
    .doc-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #F1F5F9; }
    .doc-item:last-child { border-bottom: none; }
    .doc-info { display: flex; align-items: center; gap: 12px; }
    .doc-icon { color: #EF4444; font-size: 20px; }
    .doc-title { font-size: 14px; font-weight: 500; color: #1E293B; display: block; }
    .doc-date { font-size: 12px; color: #64748B; }
    .btn-download { color: #3B82F6; background: #EFF6FF; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; }
    .btn-download:hover { background: #DBEAFE; }

    .table-card { background: #fff; border-radius: 12px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 32px; }
    .table-header { padding: 20px; border-bottom: 1px solid #F1F5F9; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #F8FAFC; padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; }
    .data-table td { padding: 16px 20px; border-bottom: 1px solid #F1F5F9; font-size: 14px; color: #1E293B; }
    
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .badge-selesai { background: #ECFDF5; color: #10B981; }
    .badge-berjalan { background: #EFF6FF; color: #3B82F6; }
    .badge-tertunda { background: #FEF2F2; color: #EF4444; }

    .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
    .gallery-card { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .gallery-img { width: 100%; height: 180px; object-fit: cover; background: #E2E8F0; }
    .gallery-content { padding: 16px; }
    .gallery-title { font-size: 14px; font-weight: 600; color: #1E293B; margin-bottom: 4px; }
    .gallery-date { font-size: 12px; color: #64748B; margin-bottom: 12px; }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1>Pusat Data Pembangunan</h1>
    <p>Pantau progres, realisasi anggaran, dan dokumentasi proyek pembangunan daerah.</p>
</div>

<!-- Filter Section -->
<form method="GET" action="{{ route('pembangunan.dashboard') }}" class="filter-bar">
    <input type="text" name="search" class="filter-input" placeholder="Cari Kode/Nama Proyek..." value="{{ request('search') }}">
    <select name="kategori" class="filter-input">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <select name="status" class="filter-input">
        <option value="">Semua Status</option>
        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        <option value="Berjalan" {{ request('status') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
        <option value="Tertunda" {{ request('status') == 'Tertunda' ? 'selected' : '' }}>Tertunda</option>
    </select>
    <button type="submit" class="btn-primary-custom">Terapkan Filter</button>
</form>

<!-- KPI Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">TOTAL PROYEK</span>
            <span class="stat-value">{{ number_format($kpi['total_proyek']) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-blue"><i class="fa-solid fa-building"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">PROYEK BERJALAN</span>
            <span class="stat-value">{{ number_format($kpi['proyek_berjalan']) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-orange"><i class="fa-solid fa-person-digging"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">PROYEK SELESAI</span>
            <span class="stat-value">{{ number_format($kpi['proyek_selesai']) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-green"><i class="fa-solid fa-check-to-slot"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">PROYEK TERTUNDA</span>
            <span class="stat-value">{{ number_format($kpi['proyek_tertunda']) }}</span>
        </div>
        <div class="stat-icon-wrapper icon-red"><i class="fa-solid fa-triangle-exclamation"></i></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">TOTAL ANGGARAN</span>
            <span class="stat-value">Rp {{ number_format($kpi['total_anggaran'] / 1000000, 1) }}M</span>
        </div>
        <div class="stat-icon-wrapper icon-purple"><i class="fa-solid fa-wallet"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">TOTAL REALISASI</span>
            <span class="stat-value">Rp {{ number_format($kpi['total_realisasi'] / 1000000, 1) }}M</span>
        </div>
        <div class="stat-icon-wrapper icon-teal"><i class="fa-solid fa-money-bill-trend-up"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">RATA-RATA PROGRES</span>
            <span class="stat-value">{{ number_format($kpi['rata_progres'], 1) }}%</span>
        </div>
        <div class="stat-icon-wrapper icon-blue"><i class="fa-solid fa-chart-line"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">UPDATE TERAKHIR</span>
            <span class="stat-value" style="font-size: 18px;">{{ $kpi['update_terakhir'] }}</span>
        </div>
        <div class="stat-icon-wrapper icon-gray"><i class="fa-solid fa-clock-rotate-left"></i></div>
    </div>
</div>

<!-- Charts Section -->
<h3 class="section-title">Visualisasi Data</h3>
<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-title">Progres Proyek per Bulan</div>
        <div style="position: relative; height: 200px; width: 100%;">
            <canvas id="chartBulan"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">Sebaran Status Proyek</div>
        <div style="position: relative; height: 200px; width: 100%;">
            <canvas id="chartStatus"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">Realisasi vs Total Anggaran</div>
        <div style="position: relative; height: 200px; width: 100%;">
            <canvas id="chartRealisasi"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">Proyek Berdasarkan Kategori</div>
        <div style="position: relative; height: 200px; width: 100%;">
            <canvas id="chartKategori"></canvas>
        </div>
    </div>
</div>

<!-- Map and Recent Docs -->
<div class="map-docs-grid">
    <div class="map-card">
        <div class="chart-title">Peta Sebaran Proyek</div>
        <div id="map"></div>
    </div>
    <div class="docs-card">
        <div class="chart-title">Informasi Terbaru (PDF)</div>
        <ul class="doc-list">
            @forelse($recentDocs as $doc)
            <li class="doc-item">
                <div class="doc-info">
                    <i class="fa-regular fa-file-pdf doc-icon"></i>
                    <div>
                        <span class="doc-title">{{ $doc->title }}</span>
                        <span class="doc-date">{{ \Carbon\Carbon::parse($doc->upload_date)->format('d M Y') }} • {{ $doc->project->name ?? 'Umum' }}</span>
                    </div>
                </div>
                <a href="#" class="btn-download"><i class="fa-solid fa-download"></i></a>
            </li>
            @empty
            <li class="doc-item" style="justify-content: center; color: #64748B; font-size: 13px;">Belum ada dokumen PDF.</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Table Section -->
<h3 class="section-title">Tabel Ringkas Proyek Pembangunan</h3>
<div class="table-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>KODE</th>
                <th>NAMA PROYEK</th>
                <th>KATEGORI</th>
                <th>ANGGARAN (Rp)</th>
                <th>PROGRES</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects->take(10) as $p)
            <tr>
                <td style="font-weight: 600;">{{ $p->project_code }}</td>
                <td>{{ $p->name }}<br><small style="color: #64748B;">{{ $p->kecamatan }}</small></td>
                <td>{{ $p->category }}</td>
                <td>{{ number_format($p->total_budget, 0, ',', '.') }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="flex: 1; height: 6px; background: #F1F5F9; border-radius: 3px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $p->progress_percentage }}%; background: #3B82F6;"></div>
                        </div>
                        <span style="font-size: 12px; font-weight: 600;">{{ $p->progress_percentage }}%</span>
                    </div>
                </td>
                <td>
                    @if($p->status == 'Selesai')
                        <span class="badge badge-selesai">Selesai</span>
                    @elseif($p->status == 'Berjalan')
                        <span class="badge badge-berjalan">Berjalan</span>
                    @else
                        <span class="badge badge-tertunda">Tertunda</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #64748B;">Tidak ada data proyek.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Public Gallery Section -->
<h3 class="section-title">Dokumentasi Publik</h3>
<div class="gallery-grid">
    @forelse($publicDocs as $img)
    <div class="gallery-card">
        <img src="{{ $img->file_path }}" alt="{{ $img->title }}" class="gallery-img" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
        <div class="gallery-content">
            <div class="gallery-title">{{ $img->title }}</div>
            <div class="gallery-date"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($img->upload_date)->format('d M Y') }}</div>
            <a href="#" class="btn-download" style="display: inline-block; width: 100%; text-align: center;">Lihat Dokumentasi</a>
        </div>
    </div>
    @empty
    <div class="gallery-card" style="grid-column: span 3; text-align: center; padding: 40px; color: #64748B; background: transparent; border: 1px dashed #CBD5E1; box-shadow: none;">
        Belum ada dokumentasi publik yang diunggah.
    </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Chart Bulan
    const ctxBulan = document.getElementById('chartBulan').getContext('2d');
    new Chart(ctxBulan, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Proyek Baru',
                data: {!! json_encode(array_values($chartBulan)) !!},
                backgroundColor: '#3B82F6',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 2. Chart Status
    const ctxStatus = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Berjalan', 'Tertunda'],
            datasets: [{
                data: [{{ $chartStatus['Selesai'] }}, {{ $chartStatus['Berjalan'] }}, {{ $chartStatus['Tertunda'] }}],
                backgroundColor: ['#10B981', '#3B82F6', '#EF4444']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%' }
    });

    // 3. Chart Realisasi
    const ctxRealisasi = document.getElementById('chartRealisasi').getContext('2d');
    new Chart(ctxRealisasi, {
        type: 'bar',
        data: {
            labels: ['Total Anggaran', 'Total Realisasi'],
            datasets: [{
                label: 'Nominal (Rp)',
                data: [{{ $chartRealisasi['Total Anggaran'] }}, {{ $chartRealisasi['Total Realisasi'] }}],
                backgroundColor: ['#A855F7', '#14B8A6'],
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    // 4. Chart Kategori
    const ctxKategori = document.getElementById('chartKategori').getContext('2d');
    new Chart(ctxKategori, {
        type: 'pie',
        data: {
            labels: {!! json_encode($chartKategori['labels']) !!},
            datasets: [{
                data: {!! json_encode($chartKategori['data']) !!},
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899', '#64748B']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 5. Leaflet Map
    var map = L.map('map').setView([-7.4797, 110.2177], 13); // Magelang coords
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const mapData = {!! json_encode($mapData) !!};
    mapData.forEach(function(p) {
        let color = p.status === 'Selesai' ? 'green' : (p.status === 'Berjalan' ? 'blue' : 'red');
        let marker = L.circleMarker([p.lat, p.lng], {
            color: color, fillColor: color, fillOpacity: 0.7, radius: 8
        }).addTo(map);
        marker.bindPopup(`<b>${p.name}</b><br>Status: ${p.status}<br>Progres: ${p.progress}%`);
    });
});
</script>
@endpush
