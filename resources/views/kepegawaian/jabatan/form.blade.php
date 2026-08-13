@extends('layouts.kepegawaian')

@section('title', isset($jabatan) ? 'Edit Unit / Jabatan' : 'Tambah Unit / Jabatan')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Jabatan & Unit Kerja &nbsp;/&nbsp; <strong style="color:#0f172a;">{{ isset($jabatan) ? 'Edit Unit / Jabatan' : 'Tambah Unit / Jabatan' }}</strong>
    </div>

    <!-- Header -->
    <div style="margin-bottom:24px;">
        <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">{{ isset($jabatan) ? 'Edit Unit / Jabatan' : 'Tambah / Edit Unit / Jabatan' }}</h2>
        <p style="margin:0; color:#64748b; font-size:14px;">Form prototype untuk memperjelas alur tambah dan edit data Divisi Kepegawaian.</p>
    </div>
</div>

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:32px; max-width:800px;">
    <form action="{{ isset($jabatan) ? route('kepegawaian.jabatan.update', $jabatan->id) : route('kepegawaian.jabatan.store') }}" method="POST">
        @csrf
        @if(isset($jabatan))
            @method('PUT')
        @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Nama Unit Kerja</label>
                <input type="text" name="nama_jabatan" value="{{ old('nama_jabatan', $jabatan->nama_jabatan ?? '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Masukkan Nama Unit Kerja">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Kode Unit</label>
                <input type="text" name="kode_unit" value="{{ old('kode_unit', $jabatan->kode_unit ?? '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Masukkan Kode Unit">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Jabatan Utama</label>
                <input type="text" name="jabatan_utama" value="{{ old('jabatan_utama', $jabatan->jabatan_utama ?? '') }}" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Misal: Kepala Subbagian Umum">
            </div>
            <div style="grid-row: span 2;">
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Deskripsi Unit</label>
                <textarea name="deskripsi_unit" style="width:100%; height:130px; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; resize:none;" placeholder="Tuliskan deskripsi mengenai unit ini...">{{ old('deskripsi_unit', $jabatan->deskripsi_unit ?? '') }}</textarea>
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Status Unit</label>
                <select name="status" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                    <option value="Aktif" {{ (old('status', $jabatan->status ?? '') == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-Aktif" {{ (old('status', $jabatan->status ?? '') == 'Non-Aktif') ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
        </div>
        
        <!-- Hidden jumlah_pegawai for creation backwards compatibility -->
        @if(!isset($jabatan))
            <input type="hidden" name="jumlah_pegawai" value="0">
        @endif

        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:40px;">
            <a href="{{ route('kepegawaian.jabatan.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#64748b; padding:10px 24px; border-radius:8px; font-weight:600; text-decoration:none; display:inline-block;">Kembali</a>
            <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">{{ isset($jabatan) ? 'Update' : 'Simpan' }}</button>
        </div>
    </form>
</div>
@endsection
