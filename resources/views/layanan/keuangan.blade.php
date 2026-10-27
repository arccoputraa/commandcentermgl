@extends('layouts.app')
@section('title', 'Keuangan - Command Center Kota Magelang')
@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data Keuangan</span>
    </div>

    <!-- Hero -->
    <div class="dashboard-hero bg-blue-light">
        <h1 class="dashboard-hero-title">Pusat Data Keuangan</h1>
        <p class="dashboard-hero-desc">Informasi publik dan statistik sektoral keuangan Kota Magelang.</p>
    </div>

    <!-- 6 Stats Cards -->
    <div class="dashboard-stats-grid finance-stats-grid" style="gap: 16px; margin-top: 32px;">
        <div class="stat-card" style="padding: 18px 16px; border-top: 3px solid #E2E8F0;">
            <h3 class="stat-card-title" style="font-size: 11px; font-weight: 700; color: #64748B; margin-bottom: 6px;">TOTAL ANGGARAN</h3>
            <p class="stat-card-value" style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0;">
                @if($stats['has_budget_data'])
                    Rp{{ number_format($stats['total_anggaran'] / 1000000000, 1, ',', '.') }} M
                @else
                    Belum tersedia
                @endif
            </p>
        </div>
        <div class="stat-card" style="padding: 18px 16px; border-top: 3px solid #E2E8F0;">
            <h3 class="stat-card-title" style="font-size: 11px; font-weight: 700; color: #64748B; margin-bottom: 6px;">TOTAL REALISASI</h3>
            <p class="stat-card-value" style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0;">
                @if($stats['has_budget_data'])
                    Rp{{ number_format($stats['total_realisasi'] / 1000000000, 1, ',', '.') }} M
                @else
                    Belum tersedia
                @endif
            </p>
        </div>
        <div class="stat-card" style="padding: 18px 16px; border-top: 3px solid #E2E8F0;">
            <h3 class="stat-card-title" style="font-size: 11px; font-weight: 700; color: #64748B; margin-bottom: 6px;">PERSENTASE REALISASI</h3>
            <p class="stat-card-value" style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0;">
                {{ $stats['persentase_realisasi'] === null ? 'Belum tersedia' : number_format($stats['persentase_realisasi'], 1, ',', '.') . '%' }}
            </p>
        </div>
        <div class="stat-card" style="padding: 18px 16px; border-top: 3px solid #E2E8F0;">
            <h3 class="stat-card-title" style="font-size: 11px; font-weight: 700; color: #64748B; margin-bottom: 6px;">PENDAPATAN ASLI DAERAH</h3>
            <p class="stat-card-value" style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0;">
                @if($stats['has_pad_data'])
                    Rp{{ number_format($stats['pad'] / 1000000000, 1, ',', '.') }} M
                @else
                    Belum tersedia
                @endif
            </p>
        </div>
        <div class="stat-card" style="padding: 18px 16px; border-top: 3px solid #E2E8F0;">
            <h3 class="stat-card-title" style="font-size: 11px; font-weight: 700; color: #64748B; margin-bottom: 6px;">PENDAPATAN PAJAK DAERAH</h3>
            <p class="stat-card-value" style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0;">
                @if($stats['has_tax_data'])
                    Rp{{ number_format($stats['pajak'] / 1000000000, 1, ',', '.') }} M
                @else
                    Belum tersedia
                @endif
            </p>
        </div>
        <div class="stat-card" style="padding: 18px 16px; border-top: 3px solid #E2E8F0;">
            <h3 class="stat-card-title" style="font-size: 11px; font-weight: 700; color: #64748B; margin-bottom: 6px;">UPDATE TERAKHIR</h3>
            <p class="stat-card-value" style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0; line-height: 24px;">
                {{ $stats['update_terakhir'] ?? 'Belum tersedia' }}
            </p>
        </div>
    </div>

    <!-- Filter Bar -->
    <form class="dashboard-filter-bar" style="margin-top: 24px;" method="GET" action="{{ route('layanan') }}">
        <input type="hidden" name="dept" value="keuangan">
        <div class="filter-dropdowns" style="flex: 1; display: flex; gap: 12px; align-items: center;">
            <select name="tahun" style="min-width: 160px;">
                <option value="">Tahun Anggaran</option>
                @foreach($tahunOptions as $opt)
                    <option value="{{ $opt }}" {{ request('tahun') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
            <select name="sektor" style="min-width: 160px;">
                <option value="">Pilih Sub Bidang / Unit</option>
                @foreach($sektorOptions as $opt)
                    <option value="{{ $opt }}" {{ request('sektor') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
            <div class="filter-search" style="flex: 1; min-width: 180px;">
                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}" style="width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 16px; font-size: 14px;" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="background: #155DFC; color: #fff; border-radius: 12px; padding: 12px 24px; font-weight: 600; border: none; cursor: pointer;">Terapkan Filter</button>
    </form>

    <!-- 4 Charts Grid (2x2) -->
    <div class="dashboard-charts-grid" style="grid-template-columns: repeat(2, 1fr); gap: 24px; margin-top: 24px;">
        
        <!-- 1. Grafik Anggaran vs Realisasi (Clustered Horizontal Bar Chart) -->
        <div class="dashboard-chart-card" style="border-radius: 18px; padding: 22px 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="chart-header" style="margin: 0; font-size: 13px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">GRAFIK ANGGARAN VS REALISASI</h3>
                <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #64748B;">
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #155DFC;"></span> Anggaran
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #00BC7D;"></span> Realisasi
                    </span>
                </div>
            </div>
            @if(count($chartAnggaran['labels']) > 0)
                <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                    <canvas id="chartAnggaranVsRealisasi"></canvas>
                </div>
            @else
                <p style="color:#64748b; text-align:center; padding:80px 0;">Data anggaran belum tersedia.</p>
            @endif
        </div>

        <!-- 2. Grafik Trend Realisasi Anggaran (Line Chart) -->
        <div class="dashboard-chart-card" style="border-radius: 18px; padding: 22px 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="chart-header" style="margin: 0; font-size: 13px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">GRAFIK TREND REALISASI ANGGARAN</h3>
                <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #64748B;">
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #00BC7D;"></span> Tren Realisasi
                    </span>
                </div>
            </div>
            @if(count($chartTrend['labels']) > 0)
                <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                    <canvas id="chartTrendRealisasi"></canvas>
                </div>
            @else
                <p style="color:#64748b; text-align:center; padding:80px 0;">Tren realisasi belum tersedia.</p>
            @endif
        </div>

        <!-- 3. Grafik Pendapatan Asli Daerah (Vertical Bar Chart) -->
        <div class="dashboard-chart-card" style="border-radius: 18px; padding: 22px 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="chart-header" style="margin: 0; font-size: 13px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">GRAFIK PENDAPATAN ASLI DAERAH</h3>
                <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #64748B;">
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #94A3B8;"></span> Target
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #00BC7D;"></span> Realisasi
                    </span>
                </div>
            </div>
            @if(count($chartPAD['labels']) > 0)
                <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                    <canvas id="chartPAD"></canvas>
                </div>
            @else
                <p style="color:#64748b; text-align:center; padding:80px 0;">Data PAD belum tersedia.</p>
            @endif
        </div>

        <!-- 4. Grafik Pendapatan Pajak Daerah (Clustered Horizontal Bar Chart) -->
        <div class="dashboard-chart-card" style="border-radius: 18px; padding: 22px 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="chart-header" style="margin: 0; font-size: 13px; font-weight: 700; color: #0F172A; text-transform: uppercase; letter-spacing: 0.5px;">GRAFIK PENDAPATAN PAJAK DAERAH</h3>
                <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #64748B;">
                    <span style="display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #F59E0B;"></span> Realisasi
                    </span>
                </div>
            </div>
            @if(count($chartPajak['labels']) > 0)
                <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                    <canvas id="chartPajakDaerah"></canvas>
                </div>
            @else
                <p style="color:#64748b; text-align:center; padding:80px 0;">Data realisasi pajak belum tersedia.</p>
            @endif
        </div>

    </div>

    <!-- Bottom Section: Data Keuangan Terbaru (Table) + Informasi Terbaru (Sidebar) -->
    <div class="dashboard-layout-sidebar" style="margin-top: 32px; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <!-- Left: Data Keuangan Terbaru Table -->
        <div class="dashboard-table-card" style="margin-top: 0; border-radius: 18px;">
            <div class="dashboard-table-header" style="padding: 20px 24px;">
                <h3 class="dashboard-table-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0;">Data Keuangan Terbaru</h3>
            </div>
            <div class="dashboard-table-wrap">
                <table class="dashboard-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding: 14px 18px; font-size: 11px; font-weight: 700; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">TAHUN</th>
                            <th style="padding: 14px 18px; font-size: 11px; font-weight: 700; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">KATEGORI</th>
                            <th style="padding: 14px 18px; font-size: 11px; font-weight: 700; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">SUB BIDANG / UNIT</th>
                            <th style="padding: 14px 18px; font-size: 11px; font-weight: 700; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">ANGGARAN / TARGET</th>
                            <th style="padding: 14px 18px; font-size: 11px; font-weight: 700; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">REALISASI</th>
                            <th style="padding: 14px 18px; font-size: 11px; font-weight: 700; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">PERSENTASE</th>
                            <th style="padding: 14px 18px; font-size: 11px; font-weight: 700; color: #64748B; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tabelKeuangan ?? [] as $row)
                        <tr>
                            <td style="padding: 16px 18px; font-size: 13px; color: #334155;">{{ $row['tahun'] }}</td>
                            <td style="padding: 16px 18px; font-size: 13px; color: #334155; font-weight: 500;">{{ $row['kategori'] }}</td>
                            <td style="padding: 16px 18px; font-size: 13px; color: #334155;">{{ $row['unit'] }}</td>
                            <td style="padding: 16px 18px; font-size: 13px; color: #334155; font-weight: 600;">{{ $row['anggaran'] }}</td>
                            <td style="padding: 16px 18px; font-size: 13px; color: #334155; font-weight: 600;">{{ $row['realisasi'] }}</td>
                            <td style="padding: 16px 18px; font-size: 13px; color: #334155;">{{ $row['persentase'] }}</td>
                            <td style="padding: 16px 18px; font-size: 13px;">
                                <span class="table-badge {{ $row['badge'] ?? 'success' }}" style="display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; background: #ECFDF5; color: #059669;">
                                    {{ $row['keterangan'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 24px; color: #94A3B8;">Belum ada data keuangan terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Informasi Terbaru Sidebar -->
        <div class="dashboard-sidebar-col">
            <div class="summary-widget" style="background: #fff; border: 1px solid var(--slate-100); border-radius: 18px; padding: 24px; box-shadow: var(--shadow-card);">
                <h3 class="summary-widget-title" style="font-size: 16px; font-weight: 700; color: #0F172A; margin: 0 0 16px;">Informasi Terbaru</h3>
                <div class="summary-list" style="display: flex; flex-direction: column; gap: 14px;">
                    @forelse($informasiTerbaru as $info)
                        @php
                            $documentPath = ltrim(str_replace('public/', '', (string) $info->dokumen), '/');
                            $publicDocument = $documentPath !== '' ? realpath(public_path($documentPath)) : false;
                            $publicRoot = realpath(public_path());
                            $isPublicDocument = $publicDocument && $publicRoot
                                && str_starts_with($publicDocument, $publicRoot . DIRECTORY_SEPARATOR)
                                && is_file($publicDocument);
                            $isStoredDocument = $documentPath !== '' && Storage::disk('public')->exists($documentPath);
                        @endphp
                        <div class="pub-info-item" style="margin-bottom: 0; padding: 16px; border-radius: 14px; background: #F8FAFC; border: 1px solid #F1F5F9; display: flex; flex-direction: column; gap: 8px;">
                            <div>
                                <p class="pub-info-title" style="font-size: 14px; font-weight: 700; color: #0F172A; margin: 0 0 4px;">{{ $info->judul }}</p>
                                <p class="pub-info-meta" style="font-size: 11px; color: #94A3B8; margin: 0;">{{ $info->dokumen ? basename($info->dokumen) : 'Dokumen belum tersedia' }}</p>
                            </div>
                            <div style="display: flex; justify-content: flex-end; margin-top: 4px;">
                                @if($isStoredDocument)
                                    <a href="{{ Storage::disk('public')->url($documentPath) }}" target="_blank" rel="noopener noreferrer" style="padding: 6px 16px; font-size: 12px; font-weight: 600; color: #155DFC; border: 1px solid #BFDBFE; border-radius: 8px; background: #fff; text-decoration: none; display: inline-flex; align-items: center;">
                                        Lihat {{ $info->format ?? 'dokumen' }}
                                    </a>
                                @elseif($isPublicDocument)
                                    <a href="{{ asset($documentPath) }}" target="_blank" rel="noopener noreferrer" style="padding: 6px 16px; font-size: 12px; font-weight: 600; color: #155DFC; border: 1px solid #BFDBFE; border-radius: 8px; background: #fff; text-decoration: none; display: inline-flex; align-items: center;">
                                        Lihat {{ $info->format ?? 'dokumen' }}
                                    </a>
                                @else
                                    <span style="font-size:12px; color:#64748b;">Dokumen belum tersedia.</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p style="font-size:13px; color:#64748b; text-align:center; padding:20px 0;">Belum ada informasi keuangan yang dipublikasikan.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

<style>
@media (max-width: 1200px) {
    .finance-stats-grid {
        grid-template-columns: repeat(3, 1fr) !important;
    }
}
@media (max-width: 768px) {
    .finance-stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
    .dashboard-charts-grid {
        grid-template-columns: 1fr !important;
    }
    .dashboard-layout-sidebar {
        grid-template-columns: 1fr !important;
    }
}
@media (max-width: 480px) {
    .finance-stats-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js is not loaded');
        return;
    }

    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#64748B';
    
    const baseHorizontalOptions = {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1E293B',
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    borderDash: [4, 4],
                    color: '#F1F5F9'
                },
                ticks: {
                    font: { size: 11 }
                }
            },
            y: {
                grid: { display: false },
                ticks: {
                    font: { size: 12, weight: '500' },
                    color: '#334155'
                }
            }
        }
    };

    // 1. Grafik Anggaran vs Realisasi (Horizontal Grouped / Clustered Bar)
    const ctxAnggaran = document.getElementById('chartAnggaranVsRealisasi');
    if (ctxAnggaran) {
        new Chart(ctxAnggaran.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($chartAnggaran['labels']),
                datasets: [
                    {
                        label: 'Anggaran',
                        data: @json($chartAnggaran['anggaran']),
                        backgroundColor: '#155DFC',
                        borderRadius: 6,
                        barThickness: 9,
                        categoryPercentage: 0.8,
                        barPercentage: 0.9
                    },
                    {
                        label: 'Realisasi',
                        data: @json($chartAnggaran['realisasi']),
                        backgroundColor: '#00BC7D',
                        borderRadius: 6,
                        barThickness: 9,
                        categoryPercentage: 0.8,
                        barPercentage: 0.9
                    }
                ]
            },
            options: {
                ...baseHorizontalOptions,
                plugins: {
                    ...baseHorizontalOptions.plugins,
                    legend: { display: false }
                }
            }
        });
    }

    // 2. Grafik Trend Realisasi Anggaran (Line Chart Kronologis Jan - Jun)
    const ctxTrend = document.getElementById('chartTrendRealisasi');
    if (ctxTrend) {
        const trendCanvas = ctxTrend.getContext('2d');
        let gradientTrend = trendCanvas.createLinearGradient(0, 0, 0, 240);
        gradientTrend.addColorStop(0, 'rgba(0, 188, 125, 0.28)');
        gradientTrend.addColorStop(1, 'rgba(0, 188, 125, 0.01)');

        new Chart(trendCanvas, {
            type: 'line',
            data: {
                labels: @json($chartTrend['labels']),
                datasets: [
                    {
                        label: 'Realisasi Anggaran',
                        data: @json($chartTrend['data']),
                        borderColor: '#00BC7D',
                        backgroundColor: gradientTrend,
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointBackgroundColor: '#00BC7D',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 12, weight: '500' },
                            color: '#64748B'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [4, 4],
                            color: '#F1F5F9'
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#64748B'
                        }
                    }
                }
            }
        });
    }

    // 3. Grafik Pendapatan Asli Daerah (Diagram Batang Vertikal Per Sektor)
    const ctxPAD = document.getElementById('chartPAD');
    if (ctxPAD) {
        new Chart(ctxPAD.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($chartPAD['labels']),
                datasets: [
                    {
                        label: 'Target',
                        data: @json($chartPAD['target']),
                        backgroundColor: '#CBD5E1',
                        borderRadius: { topLeft: 6, topRight: 6 },
                        barThickness: 16
                    },
                    {
                        label: 'Realisasi',
                        data: @json($chartPAD['realisasi']),
                        backgroundColor: '#00BC7D',
                        borderRadius: { topLeft: 6, topRight: 6 },
                        barThickness: 16
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, weight: '500' },
                            color: '#334155'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [4, 4],
                            color: '#F1F5F9'
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#64748B'
                        }
                    }
                }
            }
        });
    }

    // 4. Grafik Pendapatan Pajak Daerah (Diagram Batang Horizontal Berganda / Clustered)
    const ctxPajak = document.getElementById('chartPajakDaerah');
    if (ctxPajak) {
        new Chart(ctxPajak.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($chartPajak['labels']),
                datasets: [
                    {
                        label: 'Realisasi (Juta)',
                        data: @json($chartPajak['realisasi']),
                        backgroundColor: '#F59E0B',
                        borderRadius: 6,
                        barThickness: 8,
                        categoryPercentage: 0.8,
                        barPercentage: 0.9
                    }
                ]
            },
            options: {
                ...baseHorizontalOptions,
                plugins: {
                    ...baseHorizontalOptions.plugins,
                    legend: { display: false }
                }
            }
        });
    }
});
</script>
@endsection
