@extends('layouts.app')

@section('title', 'Kepegawaian - Command Center Kota Magelang')

@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Kepegawaian</span>
    </div>

    <div class="dashboard-hero bg-blue-light">
        <h1 class="dashboard-hero-title">Pusat Data Kepegawaian</h1>
        <p class="dashboard-hero-desc">Informasi publik dan statistik sektoral kepegawaian Kota Magelang.</p>
    </div>

    <div class="dashboard-stats-grid" style="grid-template-columns: repeat(4, 1fr);">
        <div class="stat-card color-blue">
            <h3 class="stat-card-title">Total Pegawai</h3>
            <p class="stat-card-value">{{ $stats['total'] ?? 0 }}</p>
            <p class="stat-card-desc">Jumlah tenaga kerja terdaftar</p>
        </div>
        <div class="stat-card color-green">
            <h3 class="stat-card-title">PNS</h3>
            <p class="stat-card-value">{{ $stats['pns'] ?? 0 }}</p>
            <p class="stat-card-desc">Aparatur sipil negara aktif</p>
        </div>
        <div class="stat-card color-orange">
            <h3 class="stat-card-title">PPPK</h3>
            <p class="stat-card-value">{{ $stats['pppk'] ?? 0 }}</p>
            <p class="stat-card-desc">Pegawai pemerintah dengan perjanjian kerja</p>
        </div>
        <div class="stat-card color-purple">
            <h3 class="stat-card-title">Non-ASN</h3>
            <p class="stat-card-value">{{ $stats['non_asn'] ?? 0 }}</p>
            <p class="stat-card-desc">Tenaga kontrak dan honorer</p>
        </div>
    </div>

    <div class="dashboard-filter-bar">
        <div class="filter-dropdowns">
            <select><option>Unit Kerja</option></select>
            <select><option>Golongan</option></select>
            <select><option>Status</option></select>
        </div>
        <div class="filter-search" style="flex:1; min-width:220px;">
            <input type="text" placeholder="Cari indikator" />
        </div>
        <button class="btn btn-outline">Terapkan Filter</button>
    </div>

    <div class="dashboard-layout-sidebar">
        <div class="dashboard-main-col">
            <div class="dashboard-chart-card">
                <h3 class="chart-header">Komposisi Jenis Pegawai</h3>
                <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                    <canvas id="chartJenisPegawai"></canvas>
                </div>
            </div>

            <div class="dashboard-charts-grid" style="margin-top: 0;">
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Pegawai Berdasarkan Unit Kerja</h3>
                    <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                        <canvas id="chartUnitKerja"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Komposisi Jenis Kelamin</h3>
                    <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                        <canvas id="chartGenderPeg"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Pegawai Berdasarkan Golongan</h3>
                    <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                        <canvas id="chartGolongan"></canvas>
                    </div>
                </div>
                <div class="dashboard-chart-card">
                    <h3 class="chart-header">Tren Mutasi dan Pensiun</h3>
                    <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                        <canvas id="chartMutasi"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-sidebar-col">
            <div class="summary-widget">
                <h3 class="summary-widget-title">Informasi Terbaru</h3>
                <p class="summary-widget-subtitle">
                    <span style="width:8px; height:8px; border-radius:50%; background:#00BC7D;"></span>
                    Pembaruan publikasi data kepegawaian
                </p>
                <div class="summary-list">
                    @forelse($informasiTerbaru ?? [] as $info)
                    <div class="pub-info-item">
                        <div class="pub-info-header">
                            <p class="pub-info-title">{{ Str::limit($info->judul, 40) }}</p>
                        </div>
                        <p class="pub-info-meta">{{ $info->kategori }} &middot; {{ $info->created_at->format('d M Y') }}</p>
                        @if($info->dokumen)
                        <a href="{{ Storage::url($info->dokumen) }}" target="_blank" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat File</a>
                        @else
                        <a href="#" onclick="alert('File tidak tersedia.'); return false;" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-slate-400">Tidak ada file</a>
                        @endif
                    </div>
                    @empty
                    <p style="font-size:13px; color:#64748b;">Belum ada informasi terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-table-card" style="margin-top: 32px;">
        <div class="dashboard-table-header">
            <h3 class="dashboard-table-title">Tabel Ringkas Data Kepegawaian</h3>
        </div>
        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Nama Pegawai</th>
                        <th>Unit Terkait</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tabelRingkas ?? [] as $row)
                    <tr>
                        <td>{{ date('Y', strtotime($row->tanggal_efektif)) }}</td>
                        <td>{{ $row->jenis }}</td>
                        <td>{{ Str::limit($row->nama_pegawai, 25) }}</td>
                        <td>{{ Str::limit($row->keterangan ?? '-', 20) }}</td>
                        <td>
                            @php
                                $badge = 'success';
                                if($row->status_pengajuan == 'Berjalan') $badge = 'warning';
                                if($row->status_pengajuan == 'Tertunda') $badge = 'danger';
                            @endphp
                            <span class="table-badge {{ $badge }}">{{ $row->status_pengajuan }}</span>
                        </td>
                        <td><a href="#" onclick="alert('Fitur sedang dalam pengembangan.'); return false;">Lihat Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#62748E';

    const createDonut = (ctx, labels, data, colors) => new Chart(ctx, {
        type: 'doughnut',
        data: { labels, datasets: [{ data, backgroundColor: colors, borderWidth: 0 }] },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } }
        }
    });

    const createBar = (ctx, labels, data, color, horizontal = false) => new Chart(ctx, {
        type: 'bar',
        data: { labels, datasets: [{ label: 'Jumlah', data, backgroundColor: color, borderRadius: 8 }] },
        options: {
            indexAxis: horizontal ? 'y' : 'x',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#E2E8F0' } },
                x: { grid: { display: false } }
            }
        }
    });

    createDonut(document.getElementById('chartJenisPegawai'), ['PNS', 'PPPK', 'Non-ASN'], [{{ $stats['pns'] ?? 0 }}, {{ $stats['pppk'] ?? 0 }}, {{ $stats['non_asn'] ?? 0 }}], ['#155DFC', '#10B981', '#F59E0B']);
    createBar(document.getElementById('chartUnitKerja'), {!! json_encode($chartUnitKerja['labels'] ?? []) !!}, {!! json_encode($chartUnitKerja['data'] ?? []) !!}, '#6366f1', true);
    createDonut(document.getElementById('chartGenderPeg'), ['Laki-laki', 'Perempuan'], [{{ $chartGender['Laki-laki'] ?? 0 }}, {{ $chartGender['Perempuan'] ?? 0 }}], ['#155DFC', '#EC4899']);
    createBar(document.getElementById('chartGolongan'), {!! json_encode($chartGolongan['labels'] ?? []) !!}, {!! json_encode($chartGolongan['data'] ?? []) !!}, '#10B981', true);
    createBar(document.getElementById('chartMutasi'), ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'], {!! json_encode(array_values($chartMutasi ?? array_fill(1,12,0))) !!}, '#F59E0B');
});
</script>
