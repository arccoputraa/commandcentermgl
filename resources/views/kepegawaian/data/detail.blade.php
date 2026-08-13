@extends('layouts.kepegawaian')

@section('title', 'Detail Pegawai')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Data Pegawai &nbsp;/&nbsp; <strong style="color:#0f172a;">Detail Pegawai</strong>
    </div>

    <!-- Header Actions -->
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:24px; color:#1e293b; font-weight:700;">Detail Pegawai</h2>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('kepegawaian.data.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#334155; padding:8px 16px; border-radius:8px; font-weight:600; text-decoration:none;">Kembali</a>
            <button onclick="document.getElementById('mockEditModal').style.display='flex'" style="background:#4f46e5; color:#fff; border:none; padding:8px 16px; border-radius:8px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:8px;">
                <i class="fa-regular fa-pen-to-square"></i> Edit Pegawai
            </button>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">
    
    <!-- Left Section: Main Details -->
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:32px;">
        <!-- Header Profil -->
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:32px; padding-bottom:24px; border-bottom:1px solid #e2e8f0;">
            <div>
                <h3 style="margin:0 0 8px 0; font-size:20px; color:#0f172a; font-weight:700;">{{ $pegawai->nama }}</h3>
                <p style="margin:0; font-size:14px; color:#64748b; font-family:monospace;">{{ $pegawai->nip }}</p>
            </div>
            <div>
                @if($pegawai->status_pegawai == 'Aktif')
                    <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:4px 16px; border-radius:999px; font-size:12px; font-weight:600;">Aktif</span>
                @elseif($pegawai->status_pegawai == 'Mendekati Pensiun')
                    <span style="background:#fef9c3; border:1px solid #fde047; color:#854d0e; padding:4px 16px; border-radius:999px; font-size:12px; font-weight:600;">Mendekati Pensiun</span>
                @else
                    <span style="background:#f1f5f9; border:1px solid #cbd5e1; color:#475569; padding:4px 16px; border-radius:999px; font-size:12px; font-weight:600;">{{ $pegawai->status_pegawai }}</span>
                @endif
            </div>
        </div>

        <!-- Grid Detail -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Jenis Pegawai</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">{{ $pegawai->jenis_pegawai }}</p>
            </div>
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Unit Kerja</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">{{ $pegawai->unit_kerja ?? '-' }}</p>
            </div>
            
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Jabatan</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">{{ $pegawai->jabatan ?? '-' }}</p>
            </div>
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Golongan / Grade</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">{{ $pegawai->golongan ?? '-' }}</p>
            </div>

            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Jenis Kelamin</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">{{ $pegawai->jenis_kelamin ?? '-' }}</p>
            </div>
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Tanggal Masuk</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">
                    {{ $pegawai->tanggal_bergabung ? date('d M Y', strtotime($pegawai->tanggal_bergabung)) : '-' }}
                </p>
            </div>
            
            @php
                $masaKerja = '-';
                if($pegawai->tanggal_bergabung) {
                    $joinDate = new DateTime($pegawai->tanggal_bergabung);
                    $today = new DateTime('today');
                    $diff = $joinDate->diff($today);
                    $masaKerja = $diff->y . ' Tahun';
                }
            @endphp
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Masa Kerja</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">{{ $masaKerja }}</p>
            </div>
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b;">Update Terakhir</p>
                <p style="margin:0; font-size:14px; color:#0f172a; font-weight:600;">{{ $pegawai->updated_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Right Section: Riwayat Update -->
    <div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
        <h3 style="margin:0 0 24px 0; font-size:13px; color:#0f172a; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">RIWAYAT UPDATE</h3>
        
        <div style="position:relative; border-left:2px solid #e2e8f0; margin-left:12px; padding-left:24px; display:flex; flex-direction:column; gap:24px;">
            
            <!-- Update Terakhir -->
            <div style="position:relative;">
                <div style="position:absolute; left:-36px; top:0; width:22px; height:22px; background:#eff6ff; border:2px solid #3b82f6; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#3b82f6; font-size:10px;">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <h4 style="margin:0 0 4px 0; font-size:14px; color:#0f172a; font-weight:600;">Data Diverifikasi</h4>
                    <p style="margin:0 0 2px 0; font-size:12px; color:#64748b;">Operator BKD</p>
                    <p style="margin:0; font-size:11px; color:#94a3b8;">{{ $pegawai->updated_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Diperbarui -->
            <div style="position:relative;">
                <div style="position:absolute; left:-36px; top:0; width:22px; height:22px; background:#fff7ed; border:2px solid #f59e0b; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#f59e0b; font-size:10px;">
                    <i class="fa-solid fa-pen"></i>
                </div>
                <div>
                    <h4 style="margin:0 0 4px 0; font-size:14px; color:#0f172a; font-weight:600;">Data Diperbarui</h4>
                    <p style="margin:0 0 2px 0; font-size:12px; color:#64748b;">Admin Sistem</p>
                    <p style="margin:0; font-size:11px; color:#94a3b8;">{{ $pegawai->updated_at->copy()->subDays(rand(3, 15))->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Dibuat -->
            <div style="position:relative;">
                <div style="position:absolute; left:-36px; top:0; width:22px; height:22px; background:#f1f5f9; border:2px solid #94a3b8; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#64748b; font-size:10px;">
                    <i class="fa-regular fa-file"></i>
                </div>
                <div>
                    <h4 style="margin:0 0 4px 0; font-size:14px; color:#0f172a; font-weight:600;">Data Dibuat</h4>
                    <p style="margin:0 0 2px 0; font-size:12px; color:#64748b;">Sistem SIMPEG</p>
                    <p style="margin:0; font-size:11px; color:#94a3b8;">{{ $pegawai->created_at->format('d M Y') }}</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Edit Placeholder (Redirects to index for editing in this flow, or a real modal can be implemented similarly to index) -->
<div id="mockEditModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:400px; border-radius:12px; padding:24px; text-align:center;">
        <i class="fa-solid fa-circle-info" style="font-size:48px; color:#3b82f6; margin-bottom:16px;"></i>
        <h3 style="margin:0 0 8px 0;">Fitur Edit di Detail</h3>
        <p style="color:#64748b; margin:0 0 24px 0;">Untuk mengedit data pegawai, silakan kembali ke halaman <strong>Data Pegawai</strong> dan klik ikon edit (pensil kuning) pada baris data terkait.</p>
        <button onclick="document.getElementById('mockEditModal').style.display='none'" style="background:#f1f5f9; color:#475569; border:none; padding:8px 24px; border-radius:8px; font-weight:600; cursor:pointer;">Tutup</button>
    </div>
</div>
@endsection
