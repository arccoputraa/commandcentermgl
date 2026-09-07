@extends('layouts.app')
@section('title', 'Data Kesehatan - Command Center Kota Magelang')
@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Kesehatan</span>
    </div>

    <!-- Hero -->
    <div class="dashboard-hero bg-green-light" style="position:relative; overflow:hidden; padding: 32px 40px; border-radius: 16px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); margin-bottom: 28px;">
        <h1 class="dashboard-hero-title" style="font-size:28px; font-weight:700; color:#065f46; margin:0 0 8px;">Pusat Data Kesehatan</h1>
        <p class="dashboard-hero-desc" style="color:#047857; font-size:14px; max-width:460px; margin:0;">Informasi publik dan statistik sektoral kesehatan masyarakat Kota Magelang. Halaman ini berisi ringkasan program kesehatan, tren pasien, penyakit terbanyak, dan sebaran kasus.</p>
        <div style="position:absolute; right:32px; top:50%; transform:translateY(-50%); opacity:0.12; pointer-events:none;">
            <svg width="120" height="120" viewBox="0 0 24 24" fill="#009966"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/></svg>
        </div>
    </div>

    <!-- Stats Row 1 -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:16px;">
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
            <div style="background:#eff6ff; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-regular fa-file-lines" style="color:#3b82f6; font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Total Program</div>
                <div style="font-size:26px; font-weight:700; color:#0f172a;">{{ number_format($stats['total'] ?? 0) }}</div>
            </div>
        </div>
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
            <div style="background:#ecfdf5; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-users-viewfinder" style="color:#10b981; font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Pasien Terpantau</div>
                <div style="font-size:26px; font-weight:700; color:#0f172a;">{{ number_format($stats['pasien'] ?? 0) }}</div>
            </div>
        </div>
        <div style="background:#fff; border:1px solid #fecaca; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
            <div style="background:#fef2f2; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-virus" style="color:#ef4444; font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Kasus Aktif / Rawat</div>
                <div style="font-size:26px; font-weight:700; color:#0f172a;">{{ number_format($stats['kasus'] ?? 0) }}</div>
            </div>
        </div>
    </div>

    <!-- Stats Row 2 -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
            <div style="background:#faf5ff; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-shield-virus" style="color:#a855f7; font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Vaksinasi / Imunisasi</div>
                <div style="font-size:26px; font-weight:700; color:#0f172a;">{{ number_format($stats['vaksinasi'] ?? 0) }}</div>
            </div>
        </div>
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
            <div style="background:#fff7ed; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-child" style="color:#f97316; font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Pencegahan Stunting</div>
                <div style="font-size:26px; font-weight:700; color:#0f172a;">{{ number_format($stats['pencegahan_stunting'] ?? 0) }}</div>
            </div>
        </div>
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px 24px; display:flex; align-items:center; gap:16px;">
            <div style="background:#f0fdfa; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-address-card" style="color:#14b8a6; font-size:20px;"></i>
            </div>
            <div>
                <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px;">Distribusi Kartu Sehat</div>
                <div style="font-size:26px; font-weight:700; color:#0f172a;">{{ number_format($stats['kartu_sehat'] ?? 0) }}</div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('layanan') }}" style="display:flex; gap:12px; margin-bottom:24px; align-items:center; flex-wrap:wrap;">
        <input type="hidden" name="dept" value="kesehatan">
        <select name="tahun" style="border:1px solid #e2e8f0; border-radius:8px; padding:9px 16px; font-size:13px; color:#64748b; background:#fff; min-width:130px; outline:none;">
            <option value="">Semua Tahun</option>
            <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>Tahun 2026</option>
            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>Tahun 2025</option>
            <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>Tahun 2024</option>
        </select>
        <select name="faskes" style="border:1px solid #e2e8f0; border-radius:8px; padding:9px 16px; font-size:13px; color:#64748b; background:#fff; min-width:130px; outline:none;">
            <option value="">Semua Faskes</option>
            <option value="rsud_tidar" {{ request('faskes') == 'rsud_tidar' ? 'selected' : '' }}>RSUD Tidar</option>
            <option value="puskesmas_utara" {{ request('faskes') == 'puskesmas_utara' ? 'selected' : '' }}>Puskesmas Magelang Utara</option>
            <option value="puskesmas_tengah" {{ request('faskes') == 'puskesmas_tengah' ? 'selected' : '' }}>Puskesmas Magelang Tengah</option>
            <option value="puskesmas_selatan" {{ request('faskes') == 'puskesmas_selatan' ? 'selected' : '' }}>Puskesmas Magelang Selatan</option>
        </select>
        <select name="wilayah" style="border:1px solid #e2e8f0; border-radius:8px; padding:9px 16px; font-size:13px; color:#64748b; background:#fff; min-width:130px; outline:none;">
            <option value="">Semua Wilayah</option>
            <option value="Magelang Utara" {{ request('wilayah') == 'Magelang Utara' ? 'selected' : '' }}>Magelang Utara</option>
            <option value="Magelang Tengah" {{ request('wilayah') == 'Magelang Tengah' ? 'selected' : '' }}>Magelang Tengah</option>
            <option value="Magelang Selatan" {{ request('wilayah') == 'Magelang Selatan' ? 'selected' : '' }}>Magelang Selatan</option>
        </select>
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari indikator / penyakit..." style="border:1px solid #e2e8f0; border-radius:8px; padding:9px 16px; font-size:13px; color:#64748b; background:#fff; flex:1; min-width:180px; outline:none;">
        <button type="submit" style="background:#009966; color:#fff; border:none; border-radius:8px; padding:9px 22px; font-weight:600; font-size:13px; cursor:pointer;">Terapkan Filter</button>
        @if(request('tahun') || request('faskes') || request('wilayah') || request('keyword'))
            <a href="{{ route('layanan', ['dept' => 'kesehatan']) }}" style="font-size:13px; color:#ef4444; text-decoration:none; font-weight:600; padding:0 8px;">Reset</a>
        @endif
    </form>

    <!-- Main 2-column layout -->
    <div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

        <!-- Left Column -->
        <div style="display:flex; flex-direction:column; gap:24px;">

            <!-- Tren Pasien Per Bulan -->
            <div style="background:#fff; border:1px solid #f1f5f9; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
                <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin:0 0 20px 0;">Tren Pasien Per Bulan</h3>
                <div style="position:relative; height:220px;">
                    <canvas id="trenPasienChart"></canvas>
                </div>
            </div>

            <!-- 2 charts row -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div style="background:#fff; border:1px solid #f1f5f9; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
                    <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin:0 0 16px 0;">Top 5 Penyakit</h3>
                    <div style="position:relative; height:220px;">
                        <canvas id="topPenyakitChart"></canvas>
                    </div>
                </div>
                <div style="background:#fff; border:1px solid #f1f5f9; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
                    <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin:0 0 16px 0;">Kasus Aktif Berdasarkan Wilayah</h3>
                    <div style="position:relative; height:220px;">
                        <canvas id="kasusWilayahChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Sidebar -->
        <div style="display:flex; flex-direction:column; gap:20px;">

            <!-- Peta -->
            <div style="background:#fff; border:1px solid #f1f5f9; border-radius:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.05);">
                <div style="height:200px; position:relative;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15828.910901596201!2d110.2078652!3d-7.4815454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a8f4c4054a8e3%3A0xc3b4cc374be2e022!2sMagelang%2C%20Magelang%20City%2C%20Central%20Java!5e0!3m2!1sen!2sid!4v1715000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div style="padding:12px;">
                    <a href="https://maps.google.com/?q=Kota+Magelang" target="_blank" style="display:block; text-align:center; width:100%; background:#009966; color:#fff; border:none; border-radius:8px; padding:10px 0; font-weight:600; font-size:13px; cursor:pointer; text-decoration:none; box-sizing:border-box;">Buka Peta Interaktif</a>
                </div>
            </div>

            <!-- Informasi Terbaru -->
            <div style="background:#fff; border:1px solid #f1f5f9; border-radius:12px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
                <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin:0 0 16px 0; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-file-lines" style="color:#009966;"></i> Informasi Terbaru
                </h3>
                @forelse($informasi ?? [] as $info)
                <div style="border:1px solid #e2e8f0; border-radius:8px; padding:14px; margin-bottom:10px;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px;">
                        <div style="display:flex; gap:10px; align-items:flex-start; flex:1; min-width:0;">
                            <i class="fa-solid fa-file-pdf" style="color:#ef4444; font-size:18px; margin-top:2px; flex-shrink:0;"></i>
                            <div style="min-width:0;">
                                <div style="font-size:13px; font-weight:600; color:#1e293b; line-clamp:2; overflow:hidden;">{{ $info->judul }}</div>
                                <div style="font-size:11px; color:#64748b; margin-top:2px;">
                                    Dokumen PDF · {{ $info->file_pdf ? str_replace(['public/kesehatan/informasi/', 'kesehatan/informasi/'], '', $info->file_pdf) : '-' }}
                                </div>
                            </div>
                        </div>
                        <span style="background:#ecfdf5; color:#009966; padding:3px 8px; border-radius:4px; font-size:10px; font-weight:700; white-space:nowrap; flex-shrink:0;">Rilis</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px;">
                        <span style="font-size:11px; color:#94a3b8;">Diperbarui {{ \Carbon\Carbon::parse($info->updated_at)->diffForHumans() }}</span>
                        @php
                            $pdfPath = $info->file_pdf ? storage_path('app/public/kesehatan/informasi/' . basename($info->file_pdf)) : null;
                            $pdfUrl = ($pdfPath && file_exists($pdfPath))
                                ? Storage::url('kesehatan/informasi/' . $info->file_pdf)
                                : asset('dokumen/sample-laporan-keuangan.pdf');
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
</div>

<script>
(function initKesehatanCharts() {
    function start() {
        if (typeof Chart === 'undefined') {
            setTimeout(start, 50);
            return;
        }

        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.color = '#62748E';

        // 1. Tren Pasien Per Bulan
        const canvasTren = document.getElementById('trenPasienChart');
        if (canvasTren) {
            const bulanLabels = {!! json_encode($bulanList ?? ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']) !!};
            const trenData    = {!! json_encode(array_values($trenBulanan ?? array_fill(0, 12, 0))) !!};
            new Chart(canvasTren.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: bulanLabels,
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: trenData,
                        backgroundColor: '#009966',
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [4,4], color: '#E2E8F0' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // 2. Top 5 Penyakit (Horizontal Bar)
        const canvasTop = document.getElementById('topPenyakitChart');
        if (canvasTop) {
            const penyakitLabels = {!! isset($penyakit) && $penyakit->count() ? json_encode($penyakit->pluck('nama')) : json_encode(['ISPA','Hipertensi','Diabetes','Diare','DBD']) !!};
            const penyakitData   = {!! isset($penyakit) && $penyakit->count() ? json_encode($penyakit->pluck('jumlah')) : json_encode([1200,950,780,450,320]) !!};
            new Chart(canvasTop.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: penyakitLabels,
                    datasets: [{
                        label: 'Jumlah Kasus',
                        data: penyakitData,
                        backgroundColor: '#f59e0b',
                        borderRadius: 4,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, grid: { borderDash: [4,4], color: '#E2E8F0' } },
                        y: { grid: { display: false } }
                    }
                }
            });
        }

        // 3. Kasus Aktif per Wilayah (Donut)
        const canvasWilayah = document.getElementById('kasusWilayahChart');
        if (canvasWilayah) {
            const wilayahLabels = {!! isset($kasusWilayah) && $kasusWilayah->count() ? json_encode($kasusWilayah->pluck('wilayah')) : json_encode(['Magelang Utara','Magelang Tengah','Magelang Selatan']) !!};
            const wilayahData   = {!! isset($kasusWilayah) && $kasusWilayah->count() ? json_encode($kasusWilayah->pluck('total')) : json_encode([45,25,16]) !!};
            new Chart(canvasWilayah.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: wilayahLabels,
                    datasets: [{
                        data: wilayahData,
                        backgroundColor: ['#00BC7D','#E17100','#E7000B','#3B82F6'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } } }
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();
</script>

@endsection

