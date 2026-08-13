@extends('layouts.kepegawaian')

@section('title', isset($mutasi) ? 'Edit Data Mutasi / Pensiun' : 'Tambah Data Mutasi / Pensiun')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Mutasi & Pensiun &nbsp;/&nbsp; <strong style="color:#0f172a;">{{ isset($mutasi) ? 'Edit Data Mutasi / Pensiun' : 'Tambah Data Mutasi / Pensiun' }}</strong>
    </div>

    <!-- Header -->
    <div style="margin-bottom:24px;">
        <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">{{ isset($mutasi) ? 'Edit Data Mutasi / Pensiun' : 'Tambah Data Mutasi / Pensiun' }}</h2>
        <p style="margin:0; color:#64748b; font-size:14px;">Form prototype untuk memperjelas alur tambah dan edit data Divisi Kepegawaian.</p>
    </div>
</div>

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:32px; max-width:800px;">
    <form action="{{ isset($mutasi) ? route('kepegawaian.mutasi.update', $mutasi->id) : route('kepegawaian.mutasi.store') }}" method="POST">
        @csrf
        @if(isset($mutasi))
            @method('PUT')
        @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Nama Pegawai</label>
                <!-- For simplicity, use text input if existing, or select for new. 
                     Since we need to pass nip, we will just use NIP field as main identifier and mock Nama Pegawai -->
                <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $mutasi->nama_pegawai ?? '') }}" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#f8fafc;" readonly placeholder="Diisi otomatis berdasarkan NIP">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">NIP / ID Pegawai</label>
                <input type="text" name="nip" value="{{ old('nip', $mutasi->nip ?? '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Masukkan NIP">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Keterangan Mutasi / Unit Terkait</label>
                <textarea name="keterangan" style="width:100%; height:110px; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; resize:none;" placeholder="Tuliskan keterangan perpindahan unit atau alasan mutasi di sini...">{{ old('keterangan', $mutasi->keterangan ?? '') }}</textarea>
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Jenis Perubahan</label>
                <select name="jenis" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                    <option value="Mutasi Internal" {{ (old('jenis', $mutasi->jenis ?? '') == 'Mutasi Internal') ? 'selected' : '' }}>Mutasi Internal</option>
                    <option value="Pensiun" {{ (old('jenis', $mutasi->jenis ?? '') == 'Pensiun') ? 'selected' : '' }}>Pensiun</option>
                    <option value="Promosi" {{ (old('jenis', $mutasi->jenis ?? '') == 'Promosi') ? 'selected' : '' }}>Promosi</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Tanggal Efektif</label>
                <input type="date" name="tanggal_efektif" value="{{ old('tanggal_efektif', isset($mutasi) ? \Carbon\Carbon::parse($mutasi->tanggal_efektif)->format('Y-m-d') : '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr; gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Status Proses</label>
                <select name="status_pengajuan" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                    <option value="Selesai" {{ (old('status_pengajuan', $mutasi->status_pengajuan ?? '') == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                    <option value="Berjalan" {{ (old('status_pengajuan', $mutasi->status_pengajuan ?? '') == 'Berjalan') ? 'selected' : '' }}>Berjalan</option>
                    <option value="Tertunda" {{ (old('status_pengajuan', $mutasi->status_pengajuan ?? '') == 'Tertunda') ? 'selected' : '' }}>Tertunda</option>
                </select>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:40px;">
            <a href="{{ route('kepegawaian.mutasi.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#64748b; padding:10px 24px; border-radius:8px; font-weight:600; text-decoration:none; display:inline-block;">Kembali</a>
            <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">{{ isset($mutasi) ? 'Update' : 'Simpan' }}</button>
        </div>
    </form>
</div>
@endsection
