@extends('layouts.kepegawaian')

@section('title', 'Detail Informasi')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Informasi Terbaru &nbsp;/&nbsp; <strong style="color:#0f172a;">Detail</strong>
    </div>

    <!-- Header Actions -->
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:24px; color:#1e293b; font-weight:700;">Detail Informasi</h2>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('kepegawaian.informasi.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#334155; padding:8px 16px; border-radius:8px; font-weight:600; text-decoration:none;">Kembali</a>
            <a href="{{ route('kepegawaian.informasi.edit', $informasi->id) }}" style="background:#4f46e5; color:#fff; border:none; padding:8px 16px; border-radius:8px; font-weight:600; text-decoration:none; display:flex; align-items:center; gap:8px;">
                <i class="fa-regular fa-pen-to-square"></i> Edit Informasi
            </a>
        </div>
    </div>
</div>

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:32px; max-width:800px;">
    <!-- Detail Grid -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:32px; margin-bottom:32px;">
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Judul Publikasi</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $informasi->judul }}</p>
        </div>
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Kategori</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $informasi->kategori }}</p>
        </div>
        
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">File PDF</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $informasi->dokumen ?? 'dokumen-default.pdf' }}</p>
        </div>
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Tanggal Update</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $informasi->updated_at->format('d M Y') }}</p>
        </div>
        
        <div>
            <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:500;">Status Publikasi</p>
            <p style="margin:0; font-size:15px; color:#0f172a; font-weight:600;">{{ $informasi->status_publikasi }}</p>
        </div>
    </div>

    <!-- Keterangan Box -->
    <div>
        <p style="margin:0 0 8px 0; font-size:12px; color:#64748b; font-weight:500;">Keterangan</p>
        <div style="font-size:14px; color:#334155; line-height:1.6;">
            {{ $informasi->keterangan ?: '-' }}
        </div>
    </div>
</div>
@endsection
