@extends('layouts.sig')

@section('title', 'Dashboard SIG')

@section('content')
    <div class="page-header" style="margin-bottom:24px;">
        <h1 class="page-title" style="font-size:24px; font-weight:700; color:#1E293B; margin-bottom:4px;">Dashboard SIG</h1>
        <p class="page-subtitle" style="color:#64748B; font-size:14px;">Sistem Informasi Geografis & Pemetaan Wilayah Kota Magelang.</p>
    </div>

    <!-- Stat Cards -->
    <div class="stats-grid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; margin-bottom:24px;">
        <div class="admin-card stat-card" style="background:#fff; border-radius:12px; padding:20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.05); display:flex; justify-content:space-between; align-items:center;">
            <div class="stat-info">
                <h3 style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; margin:0 0 6px 0;">Total Layer</h3>
                <p style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">{{ $stats['total_layer'] ?? 0 }}</p>
            </div>
            <div class="stat-icon" style="background:#eff6ff; color:#3b82f6; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-layer-group" style="font-size:20px;"></i>
            </div>
        </div>

        <div class="admin-card stat-card" style="background:#fff; border-radius:12px; padding:20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.05); display:flex; justify-content:space-between; align-items:center;">
            <div class="stat-info">
                <h3 style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; margin:0 0 6px 0;">Layer Aktif</h3>
                <p style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">{{ $stats['layer_aktif'] ?? 0 }}</p>
            </div>
            <div class="stat-icon" style="background:#ecfdf5; color:#10b981; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-check" style="font-size:20px;"></i>
            </div>
        </div>

        <div class="admin-card stat-card" style="background:#fff; border-radius:12px; padding:20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.05); display:flex; justify-content:space-between; align-items:center;">
            <div class="stat-info">
                <h3 style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; margin:0 0 6px 0;">Total Data Spasial</h3>
                <p style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">{{ $stats['total_data'] ?? 0 }}</p>
            </div>
            <div class="stat-icon" style="background:#f5f3ff; color:#8b5cf6; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-map-location-dot" style="font-size:20px;"></i>
            </div>
        </div>

        <div class="admin-card stat-card" style="background:#fff; border-radius:12px; padding:20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.05); display:flex; justify-content:space-between; align-items:center;">
            <div class="stat-info">
                <h3 style="font-size:12px; font-weight:600; color:#64748b; text-transform:uppercase; margin:0 0 6px 0;">Dokumen SIG</h3>
                <p style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">{{ $stats['total_dokumen'] ?? 0 }}</p>
            </div>
            <div class="stat-icon" style="background:#fef2f2; color:#ef4444; width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-file-pdf" style="font-size:20px;"></i>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="dashboard-grid" style="display:grid; grid-template-columns:1fr 340px; gap:24px;">
        <!-- Left: Recent Data Spasial Table -->
        <div class="admin-card" style="background:#fff; border-radius:12px; padding:24px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.05);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h3 style="margin:0; font-size:16px; font-weight:700; color:#1E293B;">Data Spasial Terbaru</h3>
                <a href="{{ route('sig.data-spasial.index') }}" style="color:#2563eb; font-size:13px; font-weight:600; text-decoration:none;">Lihat Semua &rarr;</a>
            </div>

            @if(isset($dataSpasialTerbaru) && $dataSpasialTerbaru->count() > 0)
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; text-align:left;">
                        <thead>
                            <tr style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                                <th style="padding:10px 12px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">NAMA DATA</th>
                                <th style="padding:10px 12px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">LAYER</th>
                                <th style="padding:10px 12px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">WILAYAH</th>
                                <th style="padding:10px 12px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataSpasialTerbaru as $item)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:12px; font-size:13px; font-weight:600; color:#1e293b;">{{ $item->nama_data }}</td>
                                <td style="padding:12px; font-size:12px; color:#475569;">
                                    <span style="background:#f1f5f9; padding:2px 8px; border-radius:4px; font-size:11px;">{{ $item->layer->nama_layer ?? '-' }}</span>
                                </td>
                                <td style="padding:12px; font-size:12px; color:#475569;">{{ $item->wilayah }}</td>
                                <td style="padding:12px; font-size:13px; font-weight:700; color:#0f172a;">{{ $item->nilai_jumlah }} Titik</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color:#94a3b8; font-size:14px; text-align:center; padding:20px 0;">Belum ada data spasial.</p>
            @endif
        </div>

        <!-- Right: Quick Actions & Recent Dokumen -->
        <div style="display:flex; flex-direction:column; gap:20px;">
            <!-- Aksi Cepat -->
            <div class="admin-card" style="background:#fff; border-radius:12px; padding:20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.05);">
                <h3 style="margin:0 0 16px 0; font-size:15px; font-weight:700; color:#1E293B;">Aksi Cepat</h3>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <a href="{{ route('sig.layer.index') }}" style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; text-decoration:none; font-size:13px; font-weight:600; transition:all .2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                        <i class="fa-solid fa-layer-group" style="color:#2563eb; font-size:16px; width:20px;"></i> Kelola Layer SIG
                    </a>
                    <a href="{{ route('sig.data-spasial.index') }}" style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; text-decoration:none; font-size:13px; font-weight:600; transition:all .2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                        <i class="fa-solid fa-plus" style="color:#10b981; font-size:16px; width:20px;"></i> Tambah Data Spasial
                    </a>
                    <a href="{{ route('sig.dokumen.index') }}" style="display:flex; align-items:center; gap:10px; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; text-decoration:none; font-size:13px; font-weight:600; transition:all .2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                        <i class="fa-solid fa-file-pdf" style="color:#ef4444; font-size:16px; width:20px;"></i> Upload Dokumen SIG
                    </a>
                    <a href="{{ route('layanan', ['dept' => 'sig']) }}" target="_blank" style="display:flex; align-items:center; gap:10px; padding:10px 14px; background:#2563eb; color:#fff; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600; transition:all .2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                        <i class="fa-solid fa-globe" style="font-size:16px; width:20px;"></i> Lihat Frontend Publik SIG
                    </a>
                </div>
            </div>

            <!-- Dokumen SIG Terbaru -->
            <div class="admin-card" style="background:#fff; border-radius:12px; padding:20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.05);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <h3 style="margin:0; font-size:15px; font-weight:700; color:#1E293B;">Dokumen SIG</h3>
                    <a href="{{ route('sig.dokumen.index') }}" style="color:#2563eb; font-size:12px; font-weight:600; text-decoration:none;">Lihat Semua</a>
                </div>
                
                @if(isset($dokumen) && $dokumen->count() > 0)
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        @foreach($dokumen as $doc)
                        <div style="border:1px solid #e2e8f0; border-radius:8px; padding:12px; display:flex; items-center; gap:10px;">
                            <div style="background:#fef2f2; color:#ef4444; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fa-solid fa-file-pdf" style="font-size:16px;"></i>
                            </div>
                            <div style="min-width:0; flex:1;">
                                <div style="font-size:13px; font-weight:600; color:#1e293b; line-clamp:1; overflow:hidden;">{{ $doc->judul }}</div>
                                <div style="font-size:11px; color:#64748b; margin-top:2px;">{{ $doc->status_tag }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p style="color:#94a3b8; font-size:13px; margin:0;">Belum ada dokumen.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
