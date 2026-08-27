@extends('layouts.pembangunan')

@section('title', 'Tambah Progres Proyek')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Tambah Update Progres Proyek</h1>
        <p class="page-subtitle">Masukkan data progres terbaru untuk proyek yang sedang berjalan.</p>
    </div>
    <a href="{{ route('pembangunan.progress.index') }}" class="btn btn-outline">
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
    <form action="{{ route('pembangunan.progress.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="project_id" class="form-label">Proyek Terkait <span class="text-danger" style="display: inline;">*</span></label>
                <select class="form-control" id="project_id" name="project_id" required>
                    <option value="">Pilih Proyek</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ old('project_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->project_code }} - {{ $p->name }} (Progres Saat Ini: {{ $p->progress_percentage }}%)
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="report_date" class="form-label">Tanggal Pelaporan <span class="text-danger" style="display: inline;">*</span></label>
                    <input type="date" class="form-control" id="report_date" name="report_date" value="{{ old('report_date', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="progress_percentage" class="form-label">Persentase Progres (0-100) <span class="text-danger" style="display: inline;">*</span></label>
                    <input type="number" class="form-control" id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage') }}" min="0" max="100" required>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="realized_budget" class="form-label">Total Realisasi Anggaran Terkini (Rp)</label>
                    <input type="number" class="form-control" id="realized_budget" name="realized_budget" value="{{ old('realized_budget') }}">
                    <small style="color: var(--admin-text-muted); font-size: 12px; display: block; margin-top: 6px;">Biarkan kosong jika tidak ada perubahan anggaran cair.</small>
                </div>
            </div>
        </div>

        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Progres
            </button>
        </div>
    </form>
</div>
@endsection
