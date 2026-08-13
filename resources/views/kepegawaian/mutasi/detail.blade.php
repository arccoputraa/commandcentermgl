@extends('layouts.kepegawaian')

@section('title', 'Detail Mutasi / Pensiun')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Mutasi & Pensiun &nbsp;/&nbsp; <strong style="color:#0f172a;">Detail</strong>
    </div>

    <!-- Header Actions -->
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:24px; color:#1e293b; font-weight:700;">Detail {{ $mutasi->jenis }}</h2>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('kepegawaian.mutasi.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#334155; padding:8px 16px; border-radius:8px; font-weight:600; text-decoration:none;">Kembali</a>
            <a href="{{ route('kepegawaian.mutasi.edit', $mutasi->id) }}" style="background:#4f46e5; color:#fff; border:none; padding:8px 16px; border-radius:8px; font-weight:600; text-decoration:none; display:flex; align-items:center; gap:8px;">
                <i class="fa-regular fa-pen-to-square"></i> Edit Data
            </a>
        </div>
    </div>
</div>

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:32px; max-width:800px;">
    <!-- Card Header -->
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:32px;">
        <div>
            <h3 style="margin:0 0 4px 0; font-size:20px; color:#1e293b; font-weight:700;">{{ $mutasi->nama_pegawai }}</h3>
            <p style="margin:0; color:#64748b; font-family:monospace; font-size:14px;">{{ $mutasi->nip }}</p>
        </div>
        <div>
            @if($mutasi->status_pengajuan == 'Selesai')
                <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:6px 16px; border-radius:999px; font-size:12px; font-weight:600;">Selesai</span>
            @elseif($mutasi->status_pengajuan == 'Berjalan')
                <span style="background:#fef3c7; border:1px solid #fde047; color:#854d0e; padding:6px 16px; border-radius:999px; font-size:12px; font-weight:600;">Berjalan</span>
            @else
                <span style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:6px 16px; border-radius:999px; font-size:12px; font-weight:600;">{{ $mutasi->status_pengajuan }}</span>
            @endif
        </div>
    </div>

    <!-- Detail Grid -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:32px;">
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Jenis Perubahan</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $mutasi->jenis }}</p>
        </div>
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Unit Asal</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $mutasi->unit_asal ?? 'Sekretariat' }}</p>
        </div>
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Unit Tujuan</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $mutasi->unit_tujuan ?? 'Bidang Mutasi' }}</p>
        </div>
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Tanggal Efektif</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ \Carbon\Carbon::parse($mutasi->tanggal_efektif)->format('d M Y') }}</p>
        </div>
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Status Proses</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $mutasi->status_pengajuan }}</p>
        </div>
    </div>

    <!-- Keterangan Box -->
    <div>
        <p style="margin:0 0 8px 0; font-size:12px; color:#64748b; font-weight:500;">Keterangan</p>
        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; font-size:14px; color:#334155;">
            {{ $mutasi->keterangan ?: 'Tidak ada keterangan khusus.' }}
        </div>
    </div>
</div>
@endsection
