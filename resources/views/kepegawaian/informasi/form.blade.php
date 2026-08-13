@extends('layouts.kepegawaian')

@section('title', isset($informasi) ? 'Edit Informasi' : 'Tambah Informasi')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Informasi Terbaru &nbsp;/&nbsp; <strong style="color:#0f172a;">{{ isset($informasi) ? 'Edit Informasi' : 'Tambah Informasi' }}</strong>
    </div>

    <!-- Header -->
    <div style="margin-bottom:24px;">
        <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">{{ isset($informasi) ? 'Edit Informasi' : 'Tambah Informasi' }}</h2>
        <p style="margin:0; color:#64748b; font-size:14px;">Form prototype untuk memperjelas alur tambah dan edit data Divisi Kepegawaian.</p>
    </div>
</div>

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:32px; max-width:800px;">
    <form action="{{ isset($informasi) ? route('kepegawaian.informasi.update', $informasi->id) : route('kepegawaian.informasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($informasi))
            @method('PUT')
        @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Judul Publikasi</label>
                <input type="text" name="judul" value="{{ old('judul', $informasi->judul ?? '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Masukkan Judul">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $informasi->kategori ?? '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Misal: Regulasi, Pengumuman">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Upload File PDF</label>
                <input type="file" name="dokumen" accept=".pdf" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                @if(isset($informasi) && $informasi->dokumen)
                    <p style="margin-top:4px; font-size:12px; color:#64748b;">File saat ini: <a href="{{ asset('storage/' . $informasi->dokumen) }}" target="_blank" style="color:#4f46e5; text-decoration:none;">{{ basename($informasi->dokumen) }}</a></p>
                @endif
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Status Publikasi</label>
                <select name="status_publikasi" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                    <option value="Rilis" {{ (old('status_publikasi', $informasi->status_publikasi ?? '') == 'Rilis') ? 'selected' : '' }}>Rilis</option>
                    <option value="Draft" {{ (old('status_publikasi', $informasi->status_publikasi ?? '') == 'Draft') ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Keterangan</label>
            <textarea name="keterangan" style="width:100%; height:100px; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; resize:none;" placeholder="Tuliskan keterangan (opsional)...">{{ old('keterangan', $informasi->keterangan ?? '') }}</textarea>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:40px;">
            <a href="{{ route('kepegawaian.informasi.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#64748b; padding:10px 24px; border-radius:8px; font-weight:600; text-decoration:none; display:inline-block;">Kembali</a>
            <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">{{ isset($informasi) ? 'Update' : 'Simpan' }}</button>
        </div>
    </form>
</div>
@endsection
