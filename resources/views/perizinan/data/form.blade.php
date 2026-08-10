@extends('layouts.perizinan')

@section('title', isset($data) ? 'Edit Data Perizinan' : 'Tambah Data Perizinan')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }
    .page-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
    }
    .page-title p {
        color: #64748B;
        font-size: 14px;
    }
    .back-btn {
        color: #64748B;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.2s;
    }
    .back-btn:hover {
        color: #0F172A;
    }
    
    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 32px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        max-width: 900px;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1E293B;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 14px;
        color: #334155;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
    
    .form-actions {
        margin-top: 32px;
        display: flex;
        gap: 16px;
        border-top: 1px solid #F1F5F9;
        padding-top: 24px;
    }
    
    .btn-primary-custom {
        background: #2563EB;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-primary-custom:hover {
        background: #1D4ED8;
    }
    .btn-secondary {
        background: #F1F5F9;
        color: #475569;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-secondary:hover {
        background: #E2E8F0;
    }
    .text-danger {
        color: #DC2626;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
</style>
@endpush

@section('content')
<a href="{{ route('perizinan.data.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Data Perizinan</a>

<div class="page-header">
    <div class="page-title">
        <h1>{{ isset($data) ? 'Edit Data Perizinan' : 'Tambah Data Perizinan' }}</h1>
        <p>Isi form di bawah untuk {{ isset($data) ? 'memperbarui' : 'menambahkan' }} data perizinan.</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ isset($data) ? route('perizinan.data.update', $data->id) : route('perizinan.data.store') }}" method="POST">
        @csrf
        @if(isset($data))
            @method('PUT')
        @endif
        
        <div class="form-grid">
            <div class="form-group">
                <label>No Dokumen <span style="color:#DC2626">*</span></label>
                <input type="text" name="no_dokumen" class="form-control" value="{{ old('no_dokumen', $data->no_dokumen ?? '') }}" required placeholder="Misal: DOK-2023-001">
                @error('no_dokumen')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Nama Pemohon <span style="color:#DC2626">*</span></label>
                <input type="text" name="nama_pemohon" class="form-control" value="{{ old('nama_pemohon', $data->nama_pemohon ?? '') }}" required placeholder="Misal: PT Pemohon Jaya">
                @error('nama_pemohon')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Jenis Izin <span style="color:#DC2626">*</span></label>
                <select name="perizinan_jenis_id" class="form-control" required>
                    <option value="">Pilih Jenis Izin</option>
                    @foreach($jenisIzin as $j)
                        <option value="{{ $j->id }}" {{ (old('perizinan_jenis_id', $data->perizinan_jenis_id ?? '') == $j->id) ? 'selected' : '' }}>
                            {{ $j->jenis_izin }}
                        </option>
                    @endforeach
                </select>
                @error('perizinan_jenis_id')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Jenis Permohonan <span style="color:#DC2626">*</span></label>
                <select name="jenis_permohonan" class="form-control" required>
                    <option value="Baru" {{ (old('jenis_permohonan', $data->jenis_permohonan ?? '') == 'Baru') ? 'selected' : '' }}>Baru</option>
                    <option value="Perpanjangan" {{ (old('jenis_permohonan', $data->jenis_permohonan ?? '') == 'Perpanjangan') ? 'selected' : '' }}>Perpanjangan</option>
                </select>
                @error('jenis_permohonan')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Tanggal Pengajuan <span style="color:#DC2626">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', isset($data) ? $data->tanggal->format('Y-m-d') : '') }}" required>
                @error('tanggal')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Status <span style="color:#DC2626">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="Proses" {{ (old('status', $data->status ?? '') == 'Proses') ? 'selected' : '' }}>Proses</option>
                    <option value="Disetujui" {{ (old('status', $data->status ?? '') == 'Disetujui') ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ (old('status', $data->status ?? '') == 'Ditolak') ? 'selected' : '' }}>Ditolak</option>
                </select>
                @error('status')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group full-width">
                <label>Lokasi / Kecamatan</label>
                <input type="text" name="lokasi_kecamatan" class="form-control" value="{{ old('lokasi_kecamatan', $data->lokasi_kecamatan ?? '') }}" placeholder="Misal: DPMPTSP Kota Magelang">
                @error('lokasi_kecamatan')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group full-width">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-control" placeholder="Tuliskan detail spesifik terkait izin...">{{ old('keterangan', $data->keterangan ?? '') }}</textarea>
                @error('keterangan')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary-custom">{{ isset($data) ? 'Update Data' : 'Simpan Data' }}</button>
            <a href="{{ route('perizinan.data.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
