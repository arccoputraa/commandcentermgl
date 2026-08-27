@extends('layouts.pembangunan')

@section('title', isset($project) ? 'Edit Proyek' : 'Tambah Proyek')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">{{ isset($project) ? 'Edit Proyek' : 'Tambah Proyek Baru' }}</h1>
        <p class="page-subtitle">{{ isset($project) ? 'Perbarui informasi detail proyek pembangunan.' : 'Masukkan informasi detail untuk proyek pembangunan baru.' }}</p>
    </div>
    <a href="{{ route('pembangunan.project.index') }}" class="btn btn-outline">
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
    <form action="{{ isset($project) ? route('pembangunan.project.update', $project->id) : route('pembangunan.project.store') }}" method="POST">
        @csrf
        @if(isset($project))
            @method('PUT')
        @endif

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="project_code" class="form-label">Kode Proyek <span style="color: var(--admin-danger);">*</span></label>
                <input type="text" class="form-control" id="project_code" name="project_code" value="{{ old('project_code', $project->project_code ?? '') }}" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="name" class="form-label">Nama Proyek <span style="color: var(--admin-danger);">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name ?? '') }}" required>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="category" class="form-label">Kategori <span style="color: var(--admin-danger);">*</span></label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Infrastruktur" {{ old('category', $project->category ?? '') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="Fasilitas Umum" {{ old('category', $project->category ?? '') == 'Fasilitas Umum' ? 'selected' : '' }}>Fasilitas Umum</option>
                    <option value="Pendidikan" {{ old('category', $project->category ?? '') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="Kesehatan" {{ old('category', $project->category ?? '') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="Lainnya" {{ old('category', $project->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="status" class="form-label">Status <span style="color: var(--admin-danger);">*</span></label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Berjalan" {{ old('status', $project->status ?? '') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                    <option value="Selesai" {{ old('status', $project->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Tertunda" {{ old('status', $project->status ?? '') == 'Tertunda' ? 'selected' : '' }}>Tertunda</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $project->kecamatan ?? '') }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $project->kelurahan ?? '') }}">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="total_budget" class="form-label">Total Anggaran (Rp)</label>
                <input type="number" class="form-control" id="total_budget" name="total_budget" value="{{ old('total_budget', $project->total_budget ?? '') }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="realized_budget" class="form-label">Realisasi Anggaran (Rp)</label>
                <input type="number" class="form-control" id="realized_budget" name="realized_budget" value="{{ old('realized_budget', $project->realized_budget ?? '') }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="progress_percentage" class="form-label">Progress (%)</label>
                <input type="number" step="0.01" class="form-control" id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', $project->progress_percentage ?? '') }}">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $project->latitude ?? '') }}">
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $project->longitude ?? '') }}">
            </div>
        </div>

        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
