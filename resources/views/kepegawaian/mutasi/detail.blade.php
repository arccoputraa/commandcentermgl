@extends('layouts.kepegawaian')

@section('title', 'Detail Mutasi & Pensiun')

@section('content')
<div class="detail-container" style="background:#fff; padding:24px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.05); max-width: 600px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('kepegawaian.mutasi.index') }}" style="color:#64748b; text-decoration:none; font-size:14px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
    
    <h3 style="margin:0 0 16px 0; font-size:18px; color:#1e293b;">Detail Pengajuan Mutasi / Pensiun</h3>
    
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; width:150px; color:#64748b; font-weight:500;">NIP</th>
            <td style="padding:12px 0; color:#0f172a; font-weight:600;">{{ $mutasi->nip }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Nama Pegawai</th>
            <td style="padding:12px 0; color:#0f172a;">{{ $mutasi->nama_pegawai }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Jenis</th>
            <td style="padding:12px 0; color:#0f172a;">{{ $mutasi->jenis }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Tanggal Efektif</th>
            <td style="padding:12px 0; color:#0f172a;">{{ date('d M Y', strtotime($mutasi->tanggal_efektif)) }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9;">
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Keterangan</th>
            <td style="padding:12px 0; color:#0f172a;">{{ $mutasi->keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <th style="padding:12px 0; color:#64748b; font-weight:500;">Status Pengajuan</th>
            <td style="padding:12px 0; color:#0f172a;">
                @if($mutasi->status_pengajuan == 'Disetujui')
                    <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Disetujui</span>
                @elseif($mutasi->status_pengajuan == 'Ditolak')
                    <span style="background:#fee2e2; color:#991b1b; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Ditolak</span>
                @else
                    <span style="background:#fef08a; color:#854d0e; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Proses</span>
                @endif
            </td>
        </tr>
    </table>
</div>
@endsection
