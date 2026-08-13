@extends('layouts.kepegawaian')

@section('title', isset($pegawai) ? 'Edit Data Pegawai' : 'Tambah Data Pegawai')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Data Pegawai &nbsp;/&nbsp; <strong style="color:#0f172a;">{{ isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai' }}</strong>
    </div>

    <!-- Header -->
    <div style="margin-bottom:24px;">
        <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">{{ isset($pegawai) ? 'Edit Data Pegawai' : 'Tambah Data Pegawai' }}</h2>
        <p style="margin:0; color:#64748b; font-size:14px;">Isi form berikut dengan lengkap untuk menyimpan data pegawai.</p>
    </div>
</div>

<div style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:32px; max-width:900px;">
    <form action="{{ isset($pegawai) ? route('kepegawaian.data.update', $pegawai->id) : route('kepegawaian.data.store') }}" method="POST">
        @csrf
        @if(isset($pegawai))
            @method('PUT')
        @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">NIP / ID Pegawai</label>
                <input type="text" name="nip" value="{{ old('nip', $pegawai->nip ?? '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Masukkan NIP">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $pegawai->nama ?? '') }}" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Nama Lengkap Pegawai">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Jenis Pegawai</label>
                <select name="jenis_pegawai" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                    <option value="PNS" {{ (old('jenis_pegawai', $pegawai->jenis_pegawai ?? '') == 'PNS') ? 'selected' : '' }}>PNS</option>
                    <option value="PPPK" {{ (old('jenis_pegawai', $pegawai->jenis_pegawai ?? '') == 'PPPK') ? 'selected' : '' }}>PPPK</option>
                    <option value="Non-ASN" {{ (old('jenis_pegawai', $pegawai->jenis_pegawai ?? '') == 'Non-ASN') ? 'selected' : '' }}>Non-ASN</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Jenis Kelamin</label>
                <select name="jenis_kelamin" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                    <option value="Laki-laki" {{ (old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ (old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Unit Kerja</label>
                <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $pegawai->unit_kerja ?? '') }}" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Contoh: Sekretariat">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan ?? '') }}" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Contoh: Kepala Sub Bagian">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:24px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Golongan</label>
                <input type="text" name="golongan" value="{{ old('golongan', $pegawai->golongan ?? '') }}" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;" placeholder="Contoh: III/a">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Status</label>
                <select name="status_pegawai" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px; background:#fff;">
                    <option value="Aktif" {{ (old('status_pegawai', $pegawai->status_pegawai ?? '') == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                    <option value="Mendekati Pensiun" {{ (old('status_pegawai', $pegawai->status_pegawai ?? '') == 'Mendekati Pensiun') ? 'selected' : '' }}>Mendekati Pensiun</option>
                    <option value="Cuti" {{ (old('status_pegawai', $pegawai->status_pegawai ?? '') == 'Cuti') ? 'selected' : '' }}>Cuti</option>
                    <option value="Tugas Belajar" {{ (old('status_pegawai', $pegawai->status_pegawai ?? '') == 'Tugas Belajar') ? 'selected' : '' }}>Tugas Belajar</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:8px;">Tanggal Masuk</label>
                <input type="date" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', isset($pegawai) && $pegawai->tanggal_bergabung ? \Carbon\Carbon::parse($pegawai->tanggal_bergabung)->format('Y-m-d') : '') }}" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; outline:none; font-size:14px;">
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:40px;">
            <a href="{{ route('kepegawaian.data.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#64748b; padding:10px 24px; border-radius:8px; font-weight:600; text-decoration:none; display:inline-block;">Kembali</a>
            <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">{{ isset($pegawai) ? 'Update Data' : 'Simpan Data' }}</button>
        </div>
    </form>
</div>
@endsection
