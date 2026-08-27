@extends('layouts.kependudukan')

@section('title', 'Informasi Terbaru')

@section('content')
<style>
    .info-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:38px; }
    .info-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .info-header p { max-width:930px; font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .add-button { height:48px; min-width:245px; margin-top:4px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:14px; text-decoration:none; }
    .filter-card { display:grid; grid-template-columns:1fr 270px 270px 270px; gap:16px; padding:20px; margin-bottom:34px; background:#fff; border:1px solid #e8edf3; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.12); }
    .filter-input, .filter-select { height:50px; border:1px solid #e5e7eb; border-radius:11px; background:#fff; color:#1d293d; outline:none; font-size:18px; box-sizing:border-box; }
    .search-field { position:relative; }
    .search-field i { position:absolute; left:18px; top:50%; transform:translateY(-50%); color:#8da0bb; font-size:18px; }
    .filter-input { width:100%; padding:0 18px 0 54px; }
    .filter-input::placeholder { color:#8b96a8; }
    .filter-select { width:100%; padding:0 16px; }
    .filter-button { height:50px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:18px; font-weight:700; cursor:pointer; }
    .table-card { background:#fff; border:1px solid #e8edf3; border-radius:18px; overflow:hidden; box-shadow:0 2px 5px rgba(15,23,42,.1); }
    .table-wrap { overflow-x:auto; }
    .info-table { width:100%; min-width:1040px; border-collapse:collapse; table-layout:fixed; }
    .info-table th { background:#f8fafc; color:#708098; text-align:left; text-transform:uppercase; font-size:15px; line-height:1.25; font-weight:800; padding:24px 22px; border-bottom:1px solid #e5e7eb; }
    .info-table td { color:#253044; font-size:18px; line-height:1.35; padding:24px 22px; border-bottom:1px solid #e5e7eb; vertical-align:middle; }
    .info-table tr:last-child td { border-bottom:0; }
    .info-table .col-no { width:55px; }
    .info-table .col-title { width:300px; }
    .info-table .col-category { width:160px; }
    .info-table .col-file { width:240px; }
    .info-table .col-date { width:150px; }
    .info-table .col-status { width:150px; }
    .info-table .col-action { width:135px; text-align:right; }
    .status-pill { display:inline-flex; align-items:center; justify-content:center; padding:6px 14px; border-radius:999px; font-size:15px; font-weight:800; }
    .status-pill.release { background:#ecfdf5; border:1px solid #a7f3d0; color:#059669; }
    .status-pill.draft { background:#fffbeb; border:1px solid #fde68a; color:#d97706; }
    .action-cell { display:flex; justify-content:flex-end; gap:22px; }
    .action-link { border:0; background:transparent; padding:0; cursor:pointer; font-size:18px; line-height:1; text-decoration:none; }
    .action-link.view { color:#2563eb; }
    .action-link.edit { color:#f97316; }
    .action-link.delete { color:#ef1f1f; }
    .file-link { color:#2563eb; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    .file-link:hover { text-decoration:underline; }
    .success-alert { margin-bottom:24px; padding:14px 18px; border-radius:10px; background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; font-weight:700; }
    .table-footer { display:flex; justify-content:space-between; align-items:center; padding:24px 22px; border-top:1px solid #e5e7eb; color:#708098; font-size:18px; }
    @media (max-width:1200px) {
        .info-header { flex-direction:column; }
        .filter-card { grid-template-columns:1fr 1fr; }
    }
    @media (max-width:760px) {
        .filter-card { grid-template-columns:1fr; }
        .add-button { width:100%; min-width:0; }
        .info-header h2 { font-size:28px; }
        .info-header p { font-size:17px; }
    }
</style>

<div class="info-header">
    <div>
        <h2>Informasi Terbaru</h2>
        <p>Kelola data sumber internal kependudukan Kota Magelang dengan alur tambah, detail, edit, dan hapus/nonaktifkan.</p>
    </div>
    <a href="{{ route('kependudukan.informasi-terbaru.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i>
        Tambah Informasi
    </a>
</div>

@if(session('success'))
    <div class="success-alert">{{ session('success') }}</div>
@endif

<form class="filter-card" action="{{ route('kependudukan.informasi-terbaru.index') }}" method="GET">
    <div class="search-field">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="filter-input" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari data" aria-label="Cari informasi terbaru">
    </div>
    <select class="filter-select" name="kategori" aria-label="Pilih Kategori" style="color:#1d293d;">
        <option value="">Pilih Kategori</option>
        @foreach($kategoriOptions as $kategori)
            <option value="{{ $kategori }}" {{ ($filters['kategori'] ?? '') === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
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
        <table class="info-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-title">Judul Publikasi</th>
                    <th class="col-category">Kategori</th>
                    <th class="col-file">File PDF</th>
                    <th class="col-date">Tanggal Update</th>
                    <th class="col-status">Status Publikasi</th>
                    <th class="col-action">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informasi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['judul'] }}</td>
                        <td>{{ $item['kategori'] }}</td>
                        <td>
                            @if(!empty($item['file_path']))
                                <a class="file-link" href="{{ route('kependudukan.informasi-terbaru.pdf', $item['id']) }}" target="_blank" rel="noopener">
                                    <i class="fa-regular fa-file-pdf"></i>
                                    {{ $item['file'] }}
                                </a>
                            @else
                                {{ $item['file'] }}
                            @endif
                        </td>
                        <td>{{ $item['tanggal'] }}</td>
                        <td>
                            <span class="status-pill {{ $item['status'] === 'Rilis' ? 'release' : 'draft' }}">{{ $item['status'] }}</span>
                        </td>
                        <td>
                            <div class="action-cell">
                                <a class="action-link view" href="{{ route('kependudukan.informasi-terbaru.show', $item['id']) }}" aria-label="Lihat detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a class="action-link edit" href="{{ route('kependudukan.informasi-terbaru.edit', $item['id']) }}" aria-label="Edit informasi">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('kependudukan.informasi-terbaru.destroy', $item['id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus informasi terbaru ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-link delete" type="submit" aria-label="Hapus informasi">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:24px; text-align:center; color:#94a3b8;">Tidak ada data informasi terbaru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        <span>Menampilkan {{ count($informasi) }} data</span>
        <span>Halaman 1 dari 1</span>
    </div>
</div>
@endsection
