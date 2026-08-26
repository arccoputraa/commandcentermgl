@extends('layouts.pembangunan')

@section('title', 'Progres Proyek')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Progres Proyek</h1>
        <a href="{{ route('pembangunan.progress.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Progres
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Laporan</th>
                            <th>Kode Proyek</th>
                            <th>Nama Proyek</th>
                            <th>Progress (%)</th>
                            <th>Realisasi Anggaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($progresses as $index => $item)
                            <tr>
                                <td>{{ $progresses->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->report_date)->format('d M Y') }}</td>
                                <td>{{ $item->project->project_code ?? '-' }}</td>
                                <td>{{ $item->project->name ?? '-' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">{{ $item->progress_percentage }}%</span>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar {{ $item->progress_percentage == 100 ? 'bg-success' : 'bg-primary' }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $item->progress_percentage }}%" 
                                                 aria-valuenow="{{ $item->progress_percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->realized_budget, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data riwayat progres proyek.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $progresses->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
