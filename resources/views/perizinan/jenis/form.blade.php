@extends('layouts.perizinan')

@section('title', isset($jenis) ? 'Edit Jenis Izin & SLA' : 'Tambah Jenis Izin & SLA')

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
<a href="{{ route('perizinan.jenis.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Jenis Izin</a>

<div class="page-header">
    <div class="page-title">
        <h1>{{ isset($jenis) ? 'Edit/Simpan Jenis Izin & SLA' : 'Tambah Jenis Izin & SLA' }}</h1>
        <p>Isi form di bawah untuk mengonfigurasi pengaturan jenis perizinan dan SLA-nya.</p>
    </div>
</div>

<div class="form-card">
    <form action="{{ isset($jenis) ? route('perizinan.jenis.update', $jenis->id) : route('perizinan.jenis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($jenis))
            @method('PUT')
        @endif
        
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nama Jenis Izin <span style="color:#DC2626">*</span></label>
                <input type="text" name="jenis_izin" class="form-control" value="{{ old('jenis_izin', $jenis->jenis_izin ?? '') }}" required placeholder="Misal: Izin Mendirikan Bangunan">
                @error('jenis_izin')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Kategori <span style="color:#DC2626">*</span></label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $jenis->kategori ?? '') }}" required placeholder="Misal: Pembangunan">
                @error('kategori')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>SLA (Waktu Penyelesaian) <span style="color:#DC2626">*</span></label>
                <input type="text" name="sla" class="form-control" value="{{ old('sla', $jenis->sla ?? '') }}" required placeholder="Misal: 7 Hari Kerja">
                @error('sla')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Status <span style="color:#DC2626">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="Aktif" {{ (old('status', $jenis->status ?? '') == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ (old('status', $jenis->status ?? '') == 'Nonaktif') ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <label>Upload Dokumen Persyaratan</label>
                <input type="file" name="dokumen" class="form-control">
                @if(isset($jenis) && $jenis->dokumen)
                    <div style="margin-top: 8px; font-size: 13px; color: #2563EB;">
                        <a href="{{ Storage::url($jenis->dokumen) }}" target="_blank" style="text-decoration: none; color: inherit;">
                            <i class="fa-solid fa-file"></i> Lihat Dokumen Saat Ini
                        </a>
                    </div>
                @endif
                <span style="font-size: 12px; color: #94A3B8; margin-top: 4px; display: block;">Format PDF, DOC, JPG. Maks 5MB.</span>
                @error('dokumen')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group full-width">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-control" placeholder="Tuliskan keterangan detail terkait SLA atau persyaratan izin...">{{ old('keterangan', $jenis->keterangan ?? '') }}</textarea>
                @error('keterangan')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-primary-custom">{{ isset($jenis) ? 'Update & Simpan' : 'Simpan Jenis Izin' }}</button>
            <a href="{{ route('perizinan.jenis.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
