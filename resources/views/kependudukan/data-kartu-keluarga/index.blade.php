@extends('layouts.kependudukan')

@section('title', 'Data Kartu Keluarga')

@section('content')
<style>
    .kk-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:38px; }
    .kk-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .kk-header p { max-width:930px; font-size:20px; line-height:1.55; color:#708098; margin:0; }
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
    .kk-table { width:100%; min-width:1040px; border-collapse:collapse; table-layout:fixed; }
    .kk-table th { background:#f8fafc; color:#708098; text-align:left; text-transform:uppercase; font-size:15px; line-height:1.25; font-weight:800; padding:24px 22px; border-bottom:1px solid #e5e7eb; }
    .kk-table td { color:#253044; font-size:18px; line-height:1.35; padding:24px 22px; border-bottom:1px solid #e5e7eb; vertical-align:middle; }
    .kk-table tr:last-child td { border-bottom:0; }
    .kk-table .col-no { width:55px; }
    .kk-table .col-year { width:85px; }
    .kk-table .col-area { width:150px; }
    .kk-table .col-village { width:150px; }
    .kk-table .col-kk { width:125px; }
    .kk-table .col-number { width:145px; }
    .kk-table .col-average { width:185px; }
    .kk-table .col-date { width:150px; }
    .kk-table .col-action { width:135px; text-align:right; }
    .action-cell { display:flex; justify-content:flex-end; gap:22px; }
    .action-link { border:0; background:transparent; padding:0; cursor:pointer; font-size:18px; line-height:1; }
    .action-link.view { color:#2563eb; }
    .action-link.edit { color:#f97316; }
    .action-link.delete { color:#ef1f1f; }
    .table-footer { display:flex; justify-content:space-between; align-items:center; padding:24px 22px; border-top:1px solid #e5e7eb; color:#708098; font-size:18px; }
    .success-alert { margin-bottom:24px; padding:14px 18px; border-radius:10px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:700; }
    @media (max-width:1200px) {
        .kk-header { flex-direction:column; }
        .filter-card { grid-template-columns:1fr 1fr; }
    }
    @media (max-width:760px) {
        .filter-card { grid-template-columns:1fr; }
        .add-button { width:100%; min-width:0; }
        .kk-header h2 { font-size:28px; }
        .kk-header p { font-size:17px; }
    }
</style>

<div class="kk-header">
    <div>
        <h2>Data Kartu Keluarga</h2>
        <p>Kelola data sumber internal kependudukan Kota Magelang dengan alur tambah, detail, edit, dan hapus/nonaktifkan.</p>
    </div>
    <a href="{{ route('kependudukan.data-kartu-keluarga.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i>
        Tambah Data KK
    </a>
</div>

@if(session('success'))
    <div class="success-alert">{{ session('success') }}</div>
@endif

<form class="filter-card" action="{{ route('kependudukan.data-kartu-keluarga.index') }}" method="GET">
    <div class="search-field">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="filter-input" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari data" aria-label="Cari data kartu keluarga">
    </div>
    <select class="filter-select" name="kecamatan" aria-label="Pilih Kecamatan" style="color:#1d293d;">
        <option value="">Pilih Kecamatan</option>
        @foreach($kecamatanOptions as $kecamatan)
            <option value="{{ $kecamatan }}" {{ ($filters['kecamatan'] ?? '') === $kecamatan ? 'selected' : '' }}>{{ $kecamatan }}</option>
        @endforeach
    </select>
    <select class="filter-select" name="tahun" aria-label="Pilih Tahun" style="color:#1d293d;">
        <option value="">Pilih Tahun</option>
        @foreach($tahunOptions as $tahun)
            <option value="{{ $tahun }}" {{ (string) ($filters['tahun'] ?? '') === (string) $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
        @endforeach
    </select>
    <button class="filter-button" type="submit">Terapkan Filter</button>
</form>

<div class="table-card">
    <div class="table-wrap">
        <table class="kk-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-year">Tahun</th>
                    <th class="col-area">Kecamatan</th>
                    <th class="col-village">Kelurahan</th>
                    <th class="col-kk">Jumlah KK</th>
                    <th class="col-number">Jumlah Penduduk</th>
                    <th class="col-average">Rata-rata Anggota Keluarga</th>
                    <th class="col-date">Update Terakhir</th>
                    <th class="col-action">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kkList as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['tahun'] }}</td>
                        <td>{{ $item['kecamatan'] }}</td>
                        <td>{{ $item['kelurahan'] }}</td>
                        <td>{{ number_format($item['kk'], 0, ',', '.') }} KK</td>
                        <td>{{ number_format($item['penduduk'], 0, ',', '.') }}</td>
                        <td>{{ $item['rata_rata'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['updated_at'])->format('d M Y') }}</td>
                        <td>
                            <div class="action-cell">
                                <a class="action-link view" href="{{ route('kependudukan.data-kartu-keluarga.show', $item['id']) }}" aria-label="Lihat detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="action-link edit" href="{{ route('kependudukan.data-kartu-keluarga.edit', $item['id']) }}" aria-label="Edit data">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('kependudukan.data-kartu-keluarga.destroy', $item['id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data kartu keluarga ini?');">
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
    {{ $kkList->links() }}
</div>
@endsection
