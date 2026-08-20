@extends('layouts.kependudukan')

@section('title', 'Detail Wilayah')

@section('content')
<style>
    .detail-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:38px; }
    .detail-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .detail-header p { font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .edit-button { height:58px; min-width:190px; margin-top:28px; border:0; border-radius:14px; background:#2563eb; color:#fff; font-size:22px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:14px; text-decoration:none; }
    .detail-card { background:#fff; border:1px solid #e8edf3; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.1); padding:70px 66px 64px; }
    .detail-grid { display:grid; grid-template-columns:1fr 1fr; column-gap:190px; row-gap:48px; }
    .detail-label { color:#708098; font-size:22px; line-height:1.2; margin:0 0 10px 0; }
    .detail-value { color:#1d293d; font-size:25px; line-height:1.25; font-weight:800; margin:0; }
    .history { margin-top:64px; padding-top:48px; border-top:1px solid #e5e7eb; }
    .history h3 { color:#1d293d; font-size:30px; font-weight:800; margin:0 0 26px 0; }
    .history p { color:#53657d; font-size:22px; margin:0 0 18px 0; }
    .back-button { display:inline-flex; align-items:center; justify-content:center; height:58px; padding:0 34px; margin-top:58px; border:1px solid #e5e7eb; border-radius:14px; color:#334155; font-size:22px; font-weight:800; text-decoration:none; background:#fff; }
    @media (max-width:900px) {
        .detail-header { flex-direction:column; }
        .edit-button { margin-top:0; }
        .detail-grid { grid-template-columns:1fr; row-gap:30px; }
        .detail-card { padding:34px; }
    }
</style>

<div class="detail-header">
    <div>
        <h2>Detail Wilayah</h2>
        <p>Detail data internal untuk data wilayah.</p>
    </div>
    <a href="{{ route('kependudukan.data-wilayah.edit', $id) }}" class="edit-button">
        <i class="fa-regular fa-pen-to-square"></i>
        Edit Data
    </a>
</div>

<div class="detail-card">
    <div class="detail-grid">
        <div>
            <p class="detail-label">Kec</p>
            <p class="detail-value">{{ $item['kecamatan'] }}</p>
        </div>
        <div>
            <p class="detail-label">Kel</p>
            <p class="detail-value">{{ $item['kelurahan'] }}</p>
        </div>
        <div>
            <p class="detail-label">Kode</p>
            <p class="detail-value">{{ $item['kode'] }}</p>
        </div>
        <div>
            <p class="detail-label">Penduduk</p>
            <p class="detail-value">{{ number_format($item['penduduk'], 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="detail-label">Kk</p>
            <p class="detail-value">{{ number_format($item['kk'], 0, ',', '.') }} KK</p>
        </div>
        <div>
            <p class="detail-label">Laki</p>
            <p class="detail-value">{{ number_format($item['laki_laki'], 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="detail-label">Perempuan</p>
            <p class="detail-value">{{ number_format($item['perempuan'], 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="detail-label">Status</p>
            <p class="detail-value">{{ $item['status'] }}</p>
        </div>
    </div>

    <div class="history">
        <h3>Riwayat Perubahan</h3>
        <p>03 Jul 2026 · Data diperbarui oleh Operator Kependudukan.</p>
        <p>02 Jul 2026 · Data diverifikasi oleh koordinator bidang.</p>
    </div>

    <a href="{{ route('kependudukan.data-wilayah.index') }}" class="back-button">Kembali</a>
</div>
@endsection
