@extends('layouts.kepegawaian')

@section('title', 'Detail Informasi Terbaru')

@section('content')
<div class="detail-container" style="background:#fff; padding:24px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.05); max-width: 600px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('kepegawaian.informasi.index') }}" style="color:#64748b; text-decoration:none; font-size:14px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
    
    <h3 style="margin:0 0 16px 0; font-size:18px; color:#1e293b;">Detail Informasi / Publikasi</h3>
    
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; width:150px; color:#64748b; font-weight:500;">Judul Informasi</th>
            <td style="padding:12px 0; color:#0f172a; font-weight:600;">{{ $informasi->judul }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Kategori</th>
            <td style="padding:12px 0; color:#0f172a;">{{ $informasi->kategori }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Format</th>
            <td style="padding:12px 0; color:#0f172a;">{{ $informasi->format ?? '-' }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Tanggal Upload</th>
            <td style="padding:12px 0; color:#0f172a;">{{ $informasi->created_at->format('d M Y H:i') }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Tautan Dokumen</th>
            <td style="padding:12px 0;">
                @if($informasi->dokumen)
                    <a href="{{ $informasi->dokumen }}" target="_blank" style="color:#3b82f6; text-decoration:none; font-weight:500;">Lihat Dokumen</a>
                @else
                    <span style="color:#94a3b8;">Tidak ada file</span>
                @endif
            </td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Keterangan</th>
            <td style="padding:12px 0; color:#0f172a;">{{ $informasi->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Status Publikasi</th>
            <td style="padding:12px 0; color:#0f172a;">
                @if($informasi->status_publikasi == 'Rilis')
                    <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Rilis</span>
                @else
                    <span style="background:#f1f5f9; color:#475569; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Draft</span>
                @endif
            </td>
        </tr>
    </table>
</div>
@endsection
