@extends('layouts.kependudukan')

@section('title', 'Data Wilayah')

@section('content')
<style>
    .area-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:38px; }
    .area-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .area-header p { max-width:930px; font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .add-button { height:48px; min-width:230px; margin-top:4px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:14px; text-decoration:none; }
    .filter-card { display:grid; grid-template-columns:1fr 270px 270px 270px; gap:16px; padding:20px; margin-bottom:34px; background:#fff; border:1px solid #e8edf3; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.12); }
    .filter-input, .filter-select { height:50px; border:1px solid #e5e7eb; border-radius:11px; background:#fff; color:#1d293d; outline:none; font-size:18px; box-sizing:border-box; }
    .search-field { position:relative; }
    .search-field i { position:absolute; left:18px; top:50%; transform:translateY(-50%); color:#8da0bb; font-size:18px; }
    .filter-input { width:100%; padding:0 18px 0 54px; }
    .filter-input::placeholder { color:#8b96a8; }
    .filter-select { width:100%; color:transparent; padding:0 16px; }
    .filter-button { height:50px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:700; cursor:pointer; }
    .table-card { background:#fff; border:1px solid #e8edf3; border-radius:18px; overflow:hidden; box-shadow:0 2px 5px rgba(15,23,42,.1); }
    .table-wrap { overflow-x:auto; }
    .area-table { width:100%; min-width:1120px; border-collapse:collapse; table-layout:fixed; }
    .area-table th { background:#f8fafc; color:#708098; text-align:left; text-transform:uppercase; font-size:15px; line-height:1.25; font-weight:800; padding:24px 20px; border-bottom:1px solid #e5e7eb; }
    .area-table td { color:#253044; font-size:18px; line-height:1.35; padding:24px 20px; border-bottom:1px solid #e5e7eb; vertical-align:middle; }
    .area-table tr:last-child td { border-bottom:0; }
    .area-table .col-no { width:55px; }
    .area-table .col-area { width:135px; }
    .area-table .col-village { width:140px; }
    .area-table .col-code { width:135px; }
    .area-table .col-number { width:130px; }
    .area-table .col-kk { width:105px; }
    .area-table .col-status { width:130px; text-align:center; }
    .area-table .col-action { width:140px; text-align:right; }
    .area-table td.status-cell { text-align:center; }
    .status-pill { display:inline-flex; align-items:center; justify-content:center; min-width:58px; height:32px; padding:0 14px; border-radius:999px; background:#ecfdf5; border:1px solid #a7f3d0; color:#059669; font-size:15px; font-weight:800; box-sizing:border-box; }
    .action-cell { display:flex; justify-content:flex-end; gap:22px; }
    .action-link { border:0; background:transparent; padding:0; cursor:pointer; font-size:18px; line-height:1; }
    .action-link.view { color:#2563eb; }
    .action-link.edit { color:#f97316; }
    .action-link.disable { color:#ef1f1f; }
    .table-footer { display:flex; justify-content:space-between; align-items:center; padding:24px 22px; border-top:1px solid #e5e7eb; color:#708098; font-size:18px; }
    .success-alert { margin-bottom:24px; padding:14px 18px; border-radius:10px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:700; }
    @media (max-width:1200px) {
        .area-header { flex-direction:column; }
        .filter-card { grid-template-columns:1fr 1fr; }
    }
    @media (max-width:760px) {
        .filter-card { grid-template-columns:1fr; }
        .add-button { width:100%; min-width:0; }
        .area-header h2 { font-size:28px; }
        .area-header p { font-size:17px; }
    }
</style>

<div class="area-header">
    <div>
        <h2>Data Wilayah</h2>
        <p>Kelola data sumber internal kependudukan Kota Magelang dengan alur tambah, detail, edit, dan hapus/nonaktifkan.</p>
    </div>
    <a href="{{ route('kependudukan.data-wilayah.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i>
        Tambah Wilayah
    </a>
</div>

@if(session('success'))
    <div class="success-alert">{{ session('success') }}</div>
@endif

<form class="filter-card" action="{{ route('kependudukan.data-wilayah.index') }}" method="GET">
    <div class="search-field">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="filter-input" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari data" aria-label="Cari data wilayah">
    </div>
    <select class="filter-select" name="kecamatan" aria-label="Pilih Kecamatan" style="color:#1d293d;">
        <option value="">Pilih Kecamatan</option>
        @foreach($kecamatanOptions as $kecamatan)
            <option value="{{ $kecamatan }}" {{ ($filters['kecamatan'] ?? '') === $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
        @endforeach
    </select>
    <select class="filter-select" name="status" aria-label="Pilih Status" style="color:#1d293d;">
        <option value="">Pilih Status</option>
        @foreach($statusOptions as $status)
            <option value="{{ $status }}" {{ ($filters['status'] ?? '') === $status ? 'selected' : '' }}>{{ $status }}</option>
        @endforeach
    </select>
    <button class="filter-button" type="submit">Terapkan Filter</button>
</form>

<div class="table-card">
    <div class="table-wrap">
        <table class="area-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-area">Kecamatan</th>
                    <th class="col-village">Kelurahan</th>
                    <th class="col-code">Kode Wilayah</th>
                    <th class="col-number">Jumlah Penduduk</th>
                    <th class="col-kk">Jumlah KK</th>
                    <th class="col-number">Laki-laki</th>
                    <th class="col-number">Perempuan</th>
                    <th class="col-status">Status Wilayah</th>
                    <th class="col-action">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wilayah as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['kecamatan'] }}</td>
                        <td>{{ $item['kelurahan'] }}</td>
                        <td>{{ $item['kode'] }}</td>
                        <td>{{ number_format($item['penduduk'], 0, ',', '.') }}</td>
                        <td>{{ number_format($item['kk'], 0, ',', '.') }}<br>KK</td>
                        <td>{{ number_format($item['laki_laki'], 0, ',', '.') }}</td>
                        <td>{{ number_format($item['perempuan'], 0, ',', '.') }}</td>
                        <td class="status-cell"><span class="status-pill">{{ $item['status'] }}</span></td>
                        <td>
                            <div class="action-cell">
                                <a class="action-link view" href="{{ route('kependudukan.data-wilayah.show', $item['_id']) }}" aria-label="Lihat detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="action-link edit" href="{{ route('kependudukan.data-wilayah.edit', $item['_id']) }}" aria-label="Edit wilayah">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('kependudukan.data-wilayah.destroy', $item['_id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data wilayah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-link disable" type="submit" aria-label="Hapus wilayah">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        <span>Menampilkan {{ count($wilayah) }} data</span>
        <span>Halaman 1 dari 1</span>
    </div>
</div>
@endsection
