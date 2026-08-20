@extends('layouts.kependudukan')

@section('title', isset($item) ? 'Edit Informasi Terbaru' : 'Tambah Informasi Terbaru')

@section('content')
<style>
    .form-header { margin-bottom:32px; }
    .form-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .form-header p { font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .form-card { background:#fff; border:1px solid #e8edf3; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.1); padding:34px; }
    .form-grid { display:grid; grid-template-columns:repeat(2, 1fr); gap:22px 28px; }
    .form-group label { display:block; color:#53657d; font-size:15px; font-weight:800; margin-bottom:8px; }
    .form-group input, .form-group select { width:100%; height:48px; border:1px solid #dbe3ee; border-radius:10px; padding:0 14px; font-size:16px; color:#1d293d; box-sizing:border-box; outline:none; }
    .form-group input[type="file"] { padding:11px 14px; background:#fff; }
    .form-group input:focus, .form-group select:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.12); }
    .help-text { display:block; margin-top:6px; color:#708098; font-size:13px; line-height:1.4; }
    .error-text { display:block; margin-top:6px; color:#dc2626; font-size:13px; }
    .form-actions { display:flex; justify-content:flex-end; gap:12px; margin-top:32px; padding-top:24px; border-top:1px solid #e5e7eb; }
    .btn-save, .btn-cancel { height:46px; border-radius:10px; padding:0 22px; font-size:16px; font-weight:800; display:inline-flex; align-items:center; justify-content:center; text-decoration:none; cursor:pointer; }
    .btn-save { border:0; background:#2563eb; color:#fff; }
    .btn-cancel { border:1px solid #e5e7eb; background:#fff; color:#334155; }
    @media (max-width:760px) { .form-grid { grid-template-columns:1fr; } .form-actions { flex-direction:column-reverse; } .btn-save, .btn-cancel { width:100%; } }
</style>

@php
    $isEdit = isset($item);
    $action = $isEdit ? route('kependudukan.informasi-terbaru.update', $id) : route('kependudukan.informasi-terbaru.store');
@endphp

<div class="form-header">
    <h2>{{ $isEdit ? 'Edit Informasi' : 'Tambah Informasi' }}</h2>
    <p>{{ $isEdit ? 'Perbarui data internal untuk informasi terbaru.' : 'Tambahkan data internal informasi terbaru baru.' }}</p>
</div>

<div class="form-card">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <div class="form-group">
                <label for="judul">Judul Publikasi</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $item['judul'] ?? '') }}" required placeholder="Contoh: Laporan Mutasi Penduduk Juli 2026">
                @error('judul')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $item['kategori'] ?? '') }}" required placeholder="Contoh: Rekap Penduduk, Data Agama, Mutasi Penduduk, dll.">
                @error('kategori')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="file">File PDF</label>
                <input type="file" id="file" name="file" accept="application/pdf,.pdf" {{ $isEdit ? '' : 'required' }}>
                @if($isEdit && !empty($item['file']))
                    <span class="help-text">File saat ini: {{ $item['file'] }}. Pilih file baru jika ingin mengganti.</span>
                @else
                    <span class="help-text">Upload file PDF maksimal 10 MB.</span>
                @endif
                @error('file')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal Update</label>
                <input type="text" id="tanggal" name="tanggal" value="{{ old('tanggal', $item['tanggal'] ?? date('d M Y')) }}" required placeholder="Contoh: 03 Jul 2026">
                @error('tanggal')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="status">Status Publikasi</label>
                <select id="status" name="status" required>
                    @foreach(['Rilis', 'Draft'] as $status)
                        <option value="{{ $status }}" {{ old('status', $item['status'] ?? 'Rilis') === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @error('status')<span class="error-text">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ $isEdit ? route('kependudukan.informasi-terbaru.show', $id) : route('kependudukan.informasi-terbaru.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
