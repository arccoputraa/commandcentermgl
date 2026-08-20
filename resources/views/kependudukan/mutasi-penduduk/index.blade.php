@extends('layouts.kependudukan')

@section('title', 'Mutasi Penduduk')

@section('content')
<style>
    .mutation-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:38px; }
    .mutation-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .mutation-header p { max-width:930px; font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .add-button { height:48px; min-width:275px; margin-top:4px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:14px; text-decoration:none; }
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
    .mutation-table { width:100%; min-width:1120px; border-collapse:collapse; table-layout:fixed; }
    .mutation-table th { background:#f8fafc; color:#708098; text-align:left; text-transform:uppercase; font-size:15px; line-height:1.25; font-weight:800; padding:24px 20px; border-bottom:1px solid #e5e7eb; }
    .mutation-table td { color:#253044; font-size:18px; line-height:1.35; padding:24px 20px; border-bottom:1px solid #e5e7eb; vertical-align:middle; }
    .mutation-table tr:last-child td { border-bottom:0; }
    .mutation-table .col-no { width:55px; }
    .mutation-table .col-year { width:85px; }
    .mutation-table .col-month { width:125px; }
    .mutation-table .col-area { width:135px; }
    .mutation-table .col-village { width:140px; }
    .mutation-table .col-small { width:110px; }
    .mutation-table .col-date { width:130px; }
    .mutation-table .col-action { width:135px; text-align:right; }
    .action-cell { display:flex; justify-content:flex-end; gap:22px; }
    .action-link { border:0; background:transparent; padding:0; cursor:pointer; font-size:18px; line-height:1; }
    .action-link.view { color:#2563eb; }
    .action-link.edit { color:#f97316; }
    .action-link.delete { color:#ef1f1f; }
    .table-footer { display:flex; justify-content:space-between; align-items:center; padding:24px 22px; border-top:1px solid #e5e7eb; color:#708098; font-size:18px; }
    .success-alert { margin-bottom:24px; padding:14px 18px; border-radius:10px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:700; }
    @media (max-width:1200px) {
        .mutation-header { flex-direction:column; }
        .filter-card { grid-template-columns:1fr 1fr; }
    }
    @media (max-width:760px) {
        .filter-card { grid-template-columns:1fr; }
        .add-button { width:100%; min-width:0; }
        .mutation-header h2 { font-size:28px; }
        .mutation-header p { font-size:17px; }
    }
</style>

<div class="mutation-header">
    <div>
        <h2>Mutasi Penduduk</h2>
        <p>Kelola data sumber internal kependudukan Kota Magelang dengan alur tambah, detail, edit, dan hapus/nonaktifkan.</p>
    </div>
    <a href="{{ route('kependudukan.mutasi-penduduk.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i>
        Tambah Data Mutasi
    </a>
</div>

@if(session('success'))
    <div class="success-alert">{{ session('success') }}</div>
@endif

<form class="filter-card" action="{{ route('kependudukan.mutasi-penduduk.index') }}" method="GET">
    <div class="search-field">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="filter-input" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari data" aria-label="Cari data mutasi penduduk">
    </div>
    <select class="filter-select" name="kecamatan" aria-label="Pilih Kecamatan" style="color:#1d293d;">
        <option value="">Pilih Kecamatan</option>
        @foreach($kecamatanOptions as $kecamatan)
            <option value="{{ $kecamatan }}" {{ ($filters['kecamatan'] ?? '') === $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
        @endforeach
    </select>
    <select class="filter-select" name="bulan" aria-label="Pilih Bulan" style="color:#1d293d;">
        <option value="">Pilih Bulan</option>
        @foreach($bulanOptions as $bulan)
            <option value="{{ $bulan }}" {{ ($filters['bulan'] ?? '') === $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
        @endforeach
    </select>
    <button class="filter-button" type="submit">Terapkan Filter</button>
</form>

<div class="table-card">
    <div class="table-wrap">
        <table class="mutation-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-year">Tahun</th>
                    <th class="col-month">Bulan</th>
                    <th class="col-area">Kecamatan</th>
                    <th class="col-village">Kelurahan</th>
                    <th class="col-small">Kelahiran</th>
                    <th class="col-small">Kematian</th>
                    <th class="col-small">Pindah Datang</th>
                    <th class="col-small">Pindah Keluar</th>
                    <th class="col-date">Update Terakhir</th>
                    <th class="col-action">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mutasi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['tahun'] }}</td>
                        <td>{{ $item['bulan'] }}</td>
                        <td>{{ $item['kecamatan'] }}</td>
                        <td>{{ $item['kelurahan'] }}</td>
                        <td>{{ $item['kelahiran'] }}</td>
                        <td>{{ $item['kematian'] }}</td>
                        <td>{{ $item['pindah_datang'] }}</td>
                        <td>{{ $item['pindah_keluar'] }}</td>
                        <td>{{ $item['update'] }}</td>
                        <td>
                            <div class="action-cell">
                                <a class="action-link view" href="{{ route('kependudukan.mutasi-penduduk.show', $item['_id']) }}" aria-label="Lihat detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="action-link edit" href="{{ route('kependudukan.mutasi-penduduk.edit', $item['_id']) }}" aria-label="Edit data">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('kependudukan.mutasi-penduduk.destroy', $item['_id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data mutasi penduduk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-link delete" type="submit" aria-label="Hapus data">
                                        <i class="fa-regular fa-trash-can"></i>
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
        <span>Menampilkan {{ count($mutasi) }} data</span>
        <span>Halaman 1 dari 1</span>
    </div>
</div>
@endsection
