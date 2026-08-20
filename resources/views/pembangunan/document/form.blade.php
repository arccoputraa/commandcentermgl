@extends('layouts.pembangunan')

@section('title', isset($document) ? 'Edit Dokumen' : 'Upload Dokumen')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ isset($document) ? 'Edit Dokumen' : 'Upload Dokumen' }}</h1>
        <a href="{{ route('pembangunan.document.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($document) ? route('pembangunan.document.update', $document->id) : route('pembangunan.document.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($document))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pembangunan_project_id" class="form-label">Proyek Terkait <span class="text-danger">*</span></label>
                        <select class="form-select form-control" id="pembangunan_project_id" name="pembangunan_project_id" required>
                            <option value="">Pilih Proyek</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" {{ old('pembangunan_project_id', $document->pembangunan_project_id ?? '') == $p->id ? 'selected' : '' }}>
                                    {{ $p->project_code }} - {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $document->title ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Tipe Dokumen <span class="text-danger">*</span></label>
                        <select class="form-select form-control" id="type" name="type" required>
                            <option value="PDF" {{ old('type', $document->type ?? '') == 'PDF' ? 'selected' : '' }}>PDF (Laporan, RAB, dll)</option>
                            <option value="Image" {{ old('type', $document->type ?? '') == 'Image' ? 'selected' : '' }}>Gambar (Foto Progres, Desain)</option>
                            <option value="Lainnya" {{ old('type', $document->type ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="upload_date" class="form-label">Tanggal Dokumen <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="upload_date" name="upload_date" value="{{ old('upload_date', isset($document) ? \Carbon\Carbon::parse($document->upload_date)->format('Y-m-d') : date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="file" class="form-label">File Dokumen {{ isset($document) ? '(Biarkan kosong jika tidak ingin mengubah file)' : '*' }}</label>
                        <input type="file" class="form-control" id="file" name="file" {{ isset($document) ? '' : 'required' }}>
                        <small class="text-muted">Maksimal 10MB. Format menyesuaikan tipe.</small>
                        @if(isset($document) && $document->file_path)
                            <div class="mt-2">
                                <a href="{{ asset($document->file_path) }}" target="_blank" class="badge badge-info">Lihat file saat ini</a>
                            </div>
                        @endif
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Simpan Dokumen</button>
            </form>
        </div>
    </div>
</div>
@endsection
