@extends('layouts.pembangunan')

@section('title', isset($document) ? 'Edit Dokumen' : 'Upload Dokumen')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">{{ isset($document) ? 'Edit Dokumen' : 'Upload Dokumen' }}</h1>
        <p class="page-subtitle">Unggah dan kelola file dokumen atau gambar terkait proyek.</p>
    </div>
    <a href="{{ route('pembangunan.document.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if ($errors->any())
    <div style="background: #FEF2F2; color: #EF4444; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #FCA5A5;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="admin-card">
    <form action="{{ isset($document) ? route('pembangunan.document.update', $document->id) : route('pembangunan.document.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($document))
            @method('PUT')
        @endif

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="pembangunan_project_id" class="form-label">Proyek Terkait <span style="color: var(--admin-danger);">*</span></label>
                <select class="form-control" id="pembangunan_project_id" name="pembangunan_project_id" required>
                    <option value="">Pilih Proyek</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ old('pembangunan_project_id', $document->pembangunan_project_id ?? '') == $p->id ? 'selected' : '' }}>
                            {{ $p->project_code }} - {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="title" class="form-label">Judul Dokumen <span style="color: var(--admin-danger);">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $document->title ?? '') }}" required>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="type" class="form-label">Tipe Dokumen <span style="color: var(--admin-danger);">*</span></label>
                <select class="form-control" id="type" name="type" required>
                    <option value="PDF" {{ old('type', $document->type ?? '') == 'PDF' ? 'selected' : '' }}>PDF (Laporan, RAB, dll)</option>
                    <option value="Image" {{ old('type', $document->type ?? '') == 'Image' ? 'selected' : '' }}>Gambar (Foto Progres, Desain)</option>
                    <option value="Lainnya" {{ old('type', $document->type ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="upload_date" class="form-label">Tanggal Dokumen <span style="color: var(--admin-danger);">*</span></label>
                <input type="date" class="form-control" id="upload_date" name="upload_date" value="{{ old('upload_date', isset($document) ? \Carbon\Carbon::parse($document->upload_date)->format('Y-m-d') : date('Y-m-d')) }}" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="status_tag" class="form-label">Status Tag (Badge)</label>
                <select class="form-control" id="status_tag" name="status_tag">
                    <option value="">Pilih Status (Opsional)</option>
                    <option value="Rilis" {{ old('status_tag', $document->status_tag ?? '') == 'Rilis' ? 'selected' : '' }}>Rilis</option>
                    <option value="Draft" {{ old('status_tag', $document->status_tag ?? '') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Internal" {{ old('status_tag', $document->status_tag ?? '') == 'Internal' ? 'selected' : '' }}>Internal</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-top: 20px; margin-bottom: 0;">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $document->description ?? '') }}</textarea>
        </div>

        <div class="form-group" style="margin-top: 20px; margin-bottom: 0;">
            <label for="file" class="form-label">File Dokumen {{ isset($document) ? '(Biarkan kosong jika tidak ingin mengubah file)' : '*' }}</label>
            <input type="file" class="form-control" id="file" name="file" {{ isset($document) ? '' : 'required' }}>
            <small style="color: var(--admin-text-muted); font-size: 12px; display: block; margin-top: 6px;">Maksimal 10MB. Format menyesuaikan tipe.</small>
            @if(isset($document) && $document->file_path)
                <div style="margin-top: 12px;">
                    <a href="{{ asset($document->file_path) }}" target="_blank" class="status-badge" style="background: rgba(59, 130, 246, 0.1); color: var(--admin-primary); text-decoration: none;">
                        <i class="fas fa-file"></i> Lihat file saat ini
                    </a>
                </div>
            @endif
        </div>

        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Dokumen
            </button>
        </div>
    </form>
</div>
@endsection
