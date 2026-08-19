@extends('layouts.kependudukan')

@section('title', isset($item) ? 'Edit Data Penduduk' : 'Tambah Data Penduduk')

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
    $action = $isEdit ? route('kependudukan.data-penduduk.update', $id) : route('kependudukan.data-penduduk.store');
@endphp

<div class="form-header">
    <h2>{{ $isEdit ? 'Edit Data Penduduk' : 'Tambah Data Penduduk' }}</h2>
    <p>{{ $isEdit ? 'Perbarui data internal penduduk.' : 'Tambahkan data internal penduduk baru.' }}</p>
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
                <label for="penduduk">Jumlah Penduduk</label>
                <input type="number" id="penduduk" name="penduduk" value="{{ old('penduduk', $item['penduduk'] ?? 0) }}" required>
                @error('penduduk')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="laki_laki">Laki-laki</label>
                <input type="number" id="laki_laki" name="laki_laki" value="{{ old('laki_laki', $item['laki_laki'] ?? 0) }}" required>
                @error('laki_laki')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="perempuan">Perempuan</label>
                <input type="number" id="perempuan" name="perempuan" value="{{ old('perempuan', $item['perempuan'] ?? 0) }}" required>
                @error('perempuan')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="wajib_ktp">Wajib KTP</label>
                <input type="number" id="wajib_ktp" name="wajib_ktp" value="{{ old('wajib_ktp', $item['wajib_ktp'] ?? 0) }}" required>
                @error('wajib_ktp')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="usia_produktif">Usia Produktif</label>
                <input type="number" id="usia_produktif" name="usia_produktif" value="{{ old('usia_produktif', $item['usia_produktif'] ?? 0) }}" required>
                @error('usia_produktif')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="anak">Anak</label>
                <input type="number" id="anak" name="anak" value="{{ old('anak', $item['anak'] ?? 0) }}" required>
                @error('anak')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="lansia">Lansia</label>
                <input type="number" id="lansia" name="lansia" value="{{ old('lansia', $item['lansia'] ?? 0) }}" required>
                @error('lansia')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="kk">Jumlah KK</label>
                <input type="number" id="kk" name="kk" value="{{ old('kk', $item['kk'] ?? 0) }}" required>
                @error('kk')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="agama">Agama Mayoritas</label>
                <input type="text" id="agama" name="agama" value="{{ old('agama', $item['agama'] ?? 'Islam') }}" required>
                @error('agama')<span class="error-text">{{ $message }}</span>@enderror
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
            <a href="{{ $isEdit ? route('kependudukan.data-penduduk.show', $id) : route('kependudukan.data-penduduk.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-save">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
