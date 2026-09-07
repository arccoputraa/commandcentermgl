@extends('layouts.kesehatan')

@section('title', 'Dashboard Kesehatan')

@push('styles')
<style>
    .dashboard-header { margin-bottom: 24px; }
    .dashboard-header h1 { font-size: 22px; font-weight: 700; color: #1E293B; margin-bottom: 6px; }
    .dashboard-header p { color: #64748B; font-size: 14px; }

    .filter-bar { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
    .filter-input { padding: 9px 14px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 13px; color: #64748B; background: #fff; flex: 1; min-width: 140px; }
    .btn-primary-custom { background: #009966; color: white; border: none; padding: 9px 22px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; transition: background .2s; }
    .btn-primary-custom:hover { background: #008055; }

    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px; }
    .stat-card { background: #fff; border-radius: 12px; padding: 20px 24px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,.05); display: flex; align-items: center; gap: 16px; }
    .stat-icon-wrapper { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .stat-info { display: flex; flex-direction: column; gap: 4px; }
    .stat-label { font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: .5px; }
    .stat-value { font-size: 26px; font-weight: 700; color: #0F172A; }
    .icon-blue   { background: #EFF6FF; color: #3B82F6; }
    .icon-green  { background: #ECFDF5; color: #10B981; }
    .icon-red    { background: #FEF2F2; color: #EF4444; }
    .icon-purple { background: #FAF5FF; color: #A855F7; }
    .icon-orange { background: #FFF7ED; color: #F97316; }
    .icon-teal   { background: #F0FDFA; color: #14B8A6; }

    .content-grid { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; margin-top: 8px; }
    .chart-card { background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,.05); margin-bottom: 20px; }
    .chart-card h3 { font-size: 15px; font-weight: 700; color: #1E293B; margin: 0 0 16px 0; }
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    .info-item { border: 1px solid #E2E8F0; border-radius: 8px; padding: 14px; margin-bottom: 10px; }
    .badge-rilis { background: #ECFDF5; color: #009966; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; white-space: nowrap; }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1>Dashboard Kesehatan</h1>
    <p>Pantau program kesehatan, tren pasien, penyakit terbanyak, dan sebaran kasus masyarakat.</p>
</div>

<div class="filter-bar">
    <input type="text" class="filter-input" placeholder="Cari data...">
    <input type="text" class="filter-input" placeholder="Semua Faskes">
    <input type="text" class="filter-input" placeholder="Semua Wilayah">
    <input type="date" class="filter-input" placeholder="Bulan">
    <button class="btn-primary-custom">Terapkan Filter</button>
</div>

<!-- Stats Row 1 -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon-wrapper icon-blue"><i class="fa-regular fa-file-lines"></i></div>
        <div class="stat-info">
            <span class="stat-label">Total Program</span>
            <span class="stat-value">{{ number_format($totalProgram) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrapper icon-green"><i class="fa-solid fa-users-viewfinder"></i></div>
        <div class="stat-info">
            <span class="stat-label">Pasien Terpantau</span>
            <span class="stat-value">{{ number_format($pasienTerpantau) }}</span>
        </div>
    </div>
    <div class="stat-card" style="border-color:#fecaca;">
        <div class="stat-icon-wrapper icon-red"><i class="fa-solid fa-virus"></i></div>
        <div class="stat-info">
            <span class="stat-label">Kasus Aktif / Rawat</span>
            <span class="stat-value">{{ number_format($kasusAktif) }}</span>
        </div>
    </div>
</div>

<!-- Stats Row 2 -->
<div class="stats-grid" style="margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-icon-wrapper icon-purple"><i class="fa-solid fa-shield-virus"></i></div>
        <div class="stat-info">
            <span class="stat-label">Vaksinasi / Imunisasi</span>
            <span class="stat-value">{{ number_format($vaksinasi) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrapper icon-orange"><i class="fa-solid fa-child"></i></div>
        <div class="stat-info">
            <span class="stat-label">Pencegahan Stunting</span>
            <span class="stat-value">{{ number_format($pencegahanStunting) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-wrapper icon-teal"><i class="fa-solid fa-address-card"></i></div>
        <div class="stat-info">
            <span class="stat-label">Distribusi Kartu Sehat</span>
            <span class="stat-value">{{ number_format($kartuSehat) }}</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="content-grid">
    <!-- Left -->
    <div>
        <!-- Tren Pasien -->
        <div class="chart-card">
            <h3>Tren Pasien Per Bulan</h3>
            <div style="position:relative; height:220px;">
                <canvas id="trenPasienChart"></canvas>
            </div>
        </div>

        <!-- 2 Charts -->
        <div class="charts-row">
            <div class="chart-card" style="margin-bottom:0;">
                <h3>Top 5 Penyakit</h3>
                <div style="position:relative; height:220px;">
                    <canvas id="topPenyakitChart"></canvas>
                </div>
            </div>
            <div class="chart-card" style="margin-bottom:0;">
                <h3>Kasus Aktif Berdasarkan Wilayah</h3>
                <div style="position:relative; height:220px;">
                    <canvas id="kasusWilayahChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div>
        <!-- Peta -->
        <div style="background:#fff; border:1px solid #F1F5F9; border-radius:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.05); margin-bottom:20px;">
            <div style="height:190px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15828.910901596201!2d110.2078652!3d-7.4815454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a8f4c4054a8e3%3A0xc3b4cc374be2e022!2sMagelang%2C%20Magelang%20City%2C%20Central%20Java!5e0!3m2!1sen!2sid!4v1715000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div style="padding:12px;">
                <button style="width:100%; background:#009966; color:#fff; border:none; border-radius:8px; padding:10px; font-weight:600; font-size:13px; cursor:pointer;">Buka Peta Interaktif</button>
            </div>
        </div>

        <!-- Informasi Terbaru -->
        <div style="background:#fff; border:1px solid #F1F5F9; border-radius:12px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
            <h3 style="font-size:15px; font-weight:700; color:#1E293B; margin:0 0 16px; display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-file-lines" style="color:#009966;"></i> Informasi Terbaru
            </h3>
            @forelse($informasi ?? [] as $info)
            <div class="info-item">
                <div style="display:flex; justify-content:space-between; gap:10px; align-items:flex-start;">
                    <div style="display:flex; gap:10px; flex:1; min-width:0;">
                        <i class="fa-solid fa-file-pdf" style="color:#ef4444; font-size:18px; flex-shrink:0; margin-top:2px;"></i>
                        <div style="min-width:0;">
                            <div style="font-size:13px; font-weight:600; color:#1e293b;">{{ $info->judul }}</div>
                            <div style="font-size:11px; color:#64748b; margin-top:2px;">Dokumen PDF · {{ basename($info->file_pdf ?? '') }}</div>
                        </div>
                    </div>
                    <span class="badge-rilis">Rilis</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                    <span style="font-size:11px; color:#94a3b8;">{{ \Carbon\Carbon::parse($info->updated_at)->diffForHumans() }}</span>
                    @php
                        $pdfPath = $info->file_pdf ? storage_path('app/public/kesehatan/informasi/' . basename($info->file_pdf)) : null;
                        $pdfUrl  = ($pdfPath && file_exists($pdfPath))
                            ? asset('storage/kesehatan/informasi/' . basename($info->file_pdf))
                            : asset('sample-document.pdf');
                    @endphp
                    <a href="{{ $pdfUrl }}" target="_blank" style="font-size:12px; font-weight:600; color:#009966; text-decoration:none;">Lihat PDF</a>
                </div>
            </div>
            @empty
            <p style="font-size:13px; color:#94a3b8; text-align:center; padding:20px 0;">Belum ada informasi tersedia.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#62748E';

    // Tren Pasien Per Bulan
    new Chart(document.getElementById('trenPasienChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulanList) !!},
            datasets: [{
                label: 'Jumlah Pasien',
                data: {!! json_encode(array_values($trenBulanan)) !!},
                backgroundColor: '#009966',
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash:[4,4], color:'#E2E8F0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Top 5 Penyakit (Horizontal Bar)
    new Chart(document.getElementById('topPenyakitChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! isset($topPenyakit) ? json_encode($topPenyakit->pluck('nama')) : json_encode(['ISPA','Hipertensi','Diabetes','Diare','DBD']) !!},
            datasets: [{
                label: 'Jumlah Kasus',
                data: {!! isset($topPenyakit) ? json_encode($topPenyakit->pluck('jumlah')) : json_encode([1200,950,780,450,320]) !!},
                backgroundColor: '#f59e0b',
                borderRadius: 4,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { borderDash:[4,4], color:'#E2E8F0' } },
                y: { grid: { display: false } }
            }
        }
    });

    // Kasus per Wilayah (Donut)
    new Chart(document.getElementById('kasusWilayahChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: {!! isset($kasusWilayah) && $kasusWilayah->count() ? json_encode($kasusWilayah->pluck('wilayah')) : json_encode(['Magelang Utara','Magelang Tengah','Magelang Selatan']) !!},
            datasets: [{
                data: {!! isset($kasusWilayah) && $kasusWilayah->count() ? json_encode($kasusWilayah->pluck('total')) : json_encode([45,25,16]) !!},
                backgroundColor: ['#00BC7D','#E17100','#E7000B','#3B82F6'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 14 } } }
        }
    });
});
</script>
@endpush
