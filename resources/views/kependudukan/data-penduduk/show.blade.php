@extends('layouts.kependudukan')

@section('title', 'Detail Data Penduduk')

@section('content')
<style>
    .detail-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:38px; }
    .detail-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .detail-header p { font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .edit-button { height:48px; min-width:150px; margin-top:28px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:12px; text-decoration:none; }
    .detail-card { background:#fff; border:1px solid #e8edf3; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.1); padding:44px 52px; }
    .detail-grid { display:grid; grid-template-columns:1fr 1fr; column-gap:160px; row-gap:38px; }
    .detail-label { color:#708098; font-size:18px; line-height:1.2; margin:0 0 8px 0; }
    .detail-value { color:#1d293d; font-size:21px; line-height:1.25; font-weight:800; margin:0; }
    .history { margin-top:48px; padding-top:36px; border-top:1px solid #e5e7eb; }
    .history h3 { color:#1d293d; font-size:24px; font-weight:800; margin:0 0 24px 0; }
    .history p { color:#53657d; font-size:19px; margin:0 0 14px 0; }
    @media (max-width:900px) {
        .detail-header { flex-direction:column; }
        .edit-button { margin-top:0; }
        .detail-grid { grid-template-columns:1fr; row-gap:26px; }
        .detail-card { padding:30px; }
    }
</style>

<div class="detail-header">
    <div>
        <h2>Detail Data Penduduk</h2>
        <p>Detail data internal untuk data penduduk.</p>
    </div>
    <a href="{{ route('kependudukan.data-penduduk.edit', $id) }}" class="edit-button">
        <i class="fa-regular fa-pen-to-square"></i>
        Edit Data
    </a>
</div>

<div class="detail-card">
    <div class="detail-grid">
        <div>
            <p class="detail-label">Tahun</p>
            <p class="detail-value">{{ $item['tahun'] }}</p>
        </div>
        <div>
            <p class="detail-label">Kec</p>
            <p class="detail-value">{{ $item['kecamatan'] }}</p>
        </div>
        <div>
            <p class="detail-label">Kel</p>
            <p class="detail-value">{{ $item['kelurahan'] }}</p>
        </div>
        <div>
            <p class="detail-label">Penduduk</p>
            <p class="detail-value">{{ number_format($item['penduduk'], 0, ',', '.') }}</p>
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
            <p class="detail-label">Ktp</p>
            <p class="detail-value">{{ number_format($item['wajib_ktp'], 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="detail-label">Produktif</p>
            <p class="detail-value">{{ number_format($item['usia_produktif'], 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="detail-label">Anak</p>
            <p class="detail-value">{{ number_format($item['anak'], 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="detail-label">Lansia</p>
            <p class="detail-value">{{ number_format($item['lansia'], 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="detail-label">Kk</p>
            <p class="detail-value">{{ number_format($item['kk'], 0, ',', '.') }} KK</p>
        </div>
        <div>
            <p class="detail-label">Agama</p>
            <p class="detail-value">{{ $item['agama'] }}</p>
        </div>
        <div>
            <p class="detail-label">Update</p>
            <p class="detail-value">{{ \Carbon\Carbon::parse($item['updated_at'])->format('d M Y') }}</p>
        </div>
        <div>
            <p class="detail-label">Status</p>
            <p class="detail-value">{{ $item['status'] }}</p>
        </div>
    </div>

    <div class="history">
        <h3>Riwayat Perubahan</h3>
        <p>{{ \Carbon\Carbon::parse($item['updated_at'])->format('d M Y') }} · Data diperbarui oleh Operator Kependudukan.</p>
        <p>02 Jul 2026 · Data diverifikasi oleh koordinator bidang.</p>
    </div>
</div>
@endsection
