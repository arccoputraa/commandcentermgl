@extends('layouts.kependudukan')

@section('title', 'Detail Informasi Terbaru')

@section('content')
<style>
    .detail-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:38px; }
    .detail-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .detail-header p { font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .edit-button { height:48px; min-width:150px; margin-top:28px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:12px; text-decoration:none; }
    .detail-card { background:#fff; border:1px solid #e8edf3; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.1); padding:44px 52px; }
    .detail-grid { display:grid; grid-template-columns:1fr 1fr; column-gap:160px; row-gap:38px; }
    .detail-label { color:#708098; font-size:18px; line-height:1.2; margin:0 0 8px 0; }
    .detail-value { color:#1d293d; font-size:21px; line-height:1.25; font-weight:800; margin:0; word-break:break-word; }
    .pdf-link { color:#2563eb; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    .pdf-link:hover { text-decoration:underline; }
    .history { margin-top:48px; padding-top:36px; border-top:1px solid #e5e7eb; }
    .history h3 { color:#1d293d; font-size:24px; font-weight:800; margin:0 0 24px 0; }
    .history p { color:#53657d; font-size:19px; margin:0 0 14px 0; }
    .btn-back { display:inline-flex; align-items:center; justify-content:center; height:46px; padding:0 28px; border:1px solid #e2e8f0; border-radius:10px; background:#f8fafc; color:#475569; font-size:16px; font-weight:600; text-decoration:none; margin-top:32px; cursor:pointer; }
    .btn-back:hover { background:#f1f5f9; border-color:#cbd5e1; }
    @media (max-width:900px) {
        .detail-header { flex-direction:column; }
        .edit-button { margin-top:0; }
        .detail-grid { grid-template-columns:1fr; row-gap:26px; }
        .detail-card { padding:30px; }
    }
</style>

<div class="detail-header">
    <div>
        <h2>Detail Informasi</h2>
        <p>Detail data internal untuk informasi terbaru.</p>
    </div>
    <a href="{{ route('kependudukan.informasi-terbaru.edit', $id) }}" class="edit-button">
        <i class="fa-regular fa-pen-to-square"></i>
        Edit Data
    </a>
</div>

<div class="detail-card">
    <div class="detail-grid">
        <div>
            <p class="detail-label">Judul</p>
            <p class="detail-value">{{ $item['judul'] }}</p>
        </div>
        <div>
            <p class="detail-label">Kategori</p>
            <p class="detail-value">{{ $item['kategori'] }}</p>
        </div>
        <div>
            <p class="detail-label">File</p>
            <p class="detail-value">
                @if(!empty($item['file_path']))
                    <a class="pdf-link" href="{{ route('kependudukan.informasi-terbaru.pdf', $id) }}" target="_blank" rel="noopener">
                        <i class="fa-regular fa-file-pdf"></i>
                        {{ $item['file'] }}
                    </a>
                @else
                    {{ $item['file'] }}
                @endif
            </p>
        </div>
        <div>
            <p class="detail-label">Update</p>
            <p class="detail-value">{{ $item['tanggal'] }}</p>
        </div>
        <div>
            <p class="detail-label">Status</p>
            <p class="detail-value">{{ $item['status'] }}</p>
        </div>
    </div>

    <div class="history">
        <h3>Riwayat Perubahan</h3>
        <p>{{ $item['tanggal'] }} · Data diperbarui oleh Operator Kependudukan.</p>
        <p>02 Jul 2026 · Data diverifikasi oleh koordinator bidang.</p>
    </div>

    <a href="{{ route('kependudukan.informasi-terbaru.index') }}" class="btn-back">Kembali</a>
</div>
@endsection
