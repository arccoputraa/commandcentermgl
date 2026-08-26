@extends('layouts.pembangunan')

@section('title', 'Tambah Progres Proyek')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Update Progres Proyek</h1>
        <a href="{{ route('pembangunan.progress.index') }}" class="btn btn-secondary shadow-sm">
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
            <form action="{{ route('pembangunan.progress.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="project_id" class="form-label">Proyek Terkait <span class="text-danger">*</span></label>
                        <select class="form-select form-control" id="project_id" name="project_id" required>
                            <option value="">Pilih Proyek</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" {{ old('project_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->project_code }} - {{ $p->name }} (Progres Saat Ini: {{ $p->progress_percentage }}%)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="report_date" class="form-label">Tanggal Pelaporan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="report_date" name="report_date" value="{{ old('report_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="progress_percentage" class="form-label">Persentase Progres (0-100) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage') }}" min="0" max="100" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="realized_budget" class="form-label">Total Realisasi Anggaran Terkini (Rp)</label>
                        <input type="number" class="form-control" id="realized_budget" name="realized_budget" value="{{ old('realized_budget') }}">
                        <small class="text-muted">Biarkan kosong jika tidak ada perubahan anggaran cair.</small>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Simpan Progres</button>
            </form>
        </div>
    </div>
</div>
@endsection
