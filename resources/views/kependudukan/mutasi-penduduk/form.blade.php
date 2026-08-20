@extends('layouts.kependudukan')

@section('title', isset($item) ? 'Edit Mutasi Penduduk' : 'Tambah Data Mutasi')

@section('content')
<style>
    .form-header { margin-bottom:32px; }
    .form-header h2 { font-size:32px; line-height:1.2; font-weight:700; color:#1d293d; margin:0 0 14px 0; }
    .form-header p { font-size:20px; line-height:1.55; color:#708098; margin:0; }
    .form-card { background:#fff; border:1px solid #e8edf3; border-radius:18px; box-shadow:0 2px 5px rgba(15,23,42,.1); padding:34px; }
    .form-grid { display:grid; grid-template-columns:repeat(2, 1fr); gap:22px 28px; }
    .form-group label { display:block; color:#53657d; font-size:15px; font-weight:800; margin-bottom:8px; }
    .form-group input, .form-group select { width:100%; height:48px; border:1px solid #dbe3ee; border-radius:10px; padding:0 14px; font-size:16px; color:#1d293d; box-sizing:border-box; outline:none; }
    .form-group input:focus, .form-group select:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.12); }
    .error-text { display:block; margin-top:6px; color:#dc2626; font-size:13px; }
    .form-actions { display:flex; justify-content:flex-end; gap:12px; margin-top:32px; padding-top:24px; border-top:1px solid #e5e7eb; }
    .btn-save, .btn-cancel { height:46px; border-radius:10px; padding:0 22px; font-size:16px; font-weight:800; display:inline-flex; align-items:center; justify-content:center; text-decoration:none; cursor:pointer; }
    .btn-save { border:0; background:#2563eb; color:#fff; }
    .btn-cancel { border:1px solid #e5e7eb; background:#fff; color:#334155; }
    @media (max-width:760px) { .form-grid { grid-template-columns:1fr; } .form-actions { flex-direction:column-reverse; } .btn-save, .btn-cancel { width:100%; } }
</style>

@php
    $isEdit = isset($item);
    $action = $isEdit ? route('kependudukan.mutasi-penduduk.update', $id) : route('kependudukan.mutasi-penduduk.store');
@endphp

<div class="form-header">
    <h2>{{ $isEdit ? 'Edit Mutasi Penduduk' : 'Tambah Data Mutasi' }}</h2>
    <p>{{ $isEdit ? 'Perbarui data internal mutasi penduduk.' : 'Tambahkan data internal mutasi penduduk baru.' }}</p>
</div>

<div class="form-card">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="form-grid">
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $item['tahun'] ?? 2026) }}" required>
                @error('tahun')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="bulan">Bulan</label>
                <input type="text" id="bulan" name="bulan" value="{{ old('bulan', $item['bulan'] ?? '') }}" required>
                @error('bulan')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $item['kecamatan'] ?? '') }}" required>
                @error('kecamatan')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="kelurahan">Kelurahan</label>
                <input type="text" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $item['kelurahan'] ?? '') }}" required>
                @error('kelurahan')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="kelahiran">Kelahiran</label>
                <input type="number" id="kelahiran" name="kelahiran" value="{{ old('kelahiran', $item['kelahiran'] ?? 0) }}" required>
                @error('kelahiran')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="kematian">Kematian</label>
                <input type="number" id="kematian" name="kematian" value="{{ old('kematian', $item['kematian'] ?? 0) }}" required>
                @error('kematian')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="pindah_datang">Pindah Datang</label>
                <input type="number" id="pindah_datang" name="pindah_datang" value="{{ old('pindah_datang', $item['pindah_datang'] ?? 0) }}" required>
                @error('pindah_datang')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="pindah_keluar">Pindah Keluar</label>
                <input type="number" id="pindah_keluar" name="pindah_keluar" value="{{ old('pindah_keluar', $item['pindah_keluar'] ?? 0) }}" required>
                @error('pindah_keluar')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="update">Update Terakhir</label>
                <input type="text" id="update" name="update" value="{{ old('update', $item['update'] ?? date('d M Y')) }}" required>
                @error('update')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    @foreach(['Aktif', 'Nonaktif'] as $status)
                        <option value="{{ $status }}" {{ old('status', $item['status'] ?? 'Aktif') === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @error('status')<span class="error-text">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ $isEdit ? route('kependudukan.mutasi-penduduk.show', $id) : route('kependudukan.mutasi-penduduk.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
