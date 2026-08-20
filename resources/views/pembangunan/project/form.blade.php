@extends('layouts.pembangunan')

@section('title', isset($project) ? 'Edit Proyek' : 'Tambah Proyek')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ isset($project) ? 'Edit Proyek' : 'Tambah Proyek Baru' }}</h1>
        <a href="{{ route('pembangunan.project.index') }}" class="btn btn-secondary shadow-sm">
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
            <form action="{{ isset($project) ? route('pembangunan.project.update', $project->id) : route('pembangunan.project.store') }}" method="POST">
                @csrf
                @if(isset($project))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="project_code" class="form-label">Kode Proyek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="project_code" name="project_code" value="{{ old('project_code', $project->project_code ?? '') }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Proyek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name ?? '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select form-control" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Infrastruktur" {{ old('category', $project->category ?? '') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                            <option value="Fasilitas Umum" {{ old('category', $project->category ?? '') == 'Fasilitas Umum' ? 'selected' : '' }}>Fasilitas Umum</option>
                            <option value="Pendidikan" {{ old('category', $project->category ?? '') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Kesehatan" {{ old('category', $project->category ?? '') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="Lainnya" {{ old('category', $project->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select form-control" id="status" name="status" required>
                            <option value="Berjalan" {{ old('status', $project->status ?? '') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                            <option value="Selesai" {{ old('status', $project->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Tertunda" {{ old('status', $project->status ?? '') == 'Tertunda' ? 'selected' : '' }}>Tertunda</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $project->kecamatan ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kelurahan" class="form-label">Kelurahan</label>
                        <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $project->kelurahan ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="total_budget" class="form-label">Total Anggaran (Rp)</label>
                        <input type="number" class="form-control" id="total_budget" name="total_budget" value="{{ old('total_budget', $project->total_budget ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="realized_budget" class="form-label">Realisasi Anggaran (Rp)</label>
                        <input type="number" class="form-control" id="realized_budget" name="realized_budget" value="{{ old('realized_budget', $project->realized_budget ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="progress_percentage" class="form-label">Progress (%)</label>
                        <input type="number" step="0.01" class="form-control" id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', $project->progress_percentage ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $project->latitude ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $project->longitude ?? '') }}">
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
