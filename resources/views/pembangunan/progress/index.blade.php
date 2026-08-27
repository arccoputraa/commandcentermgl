@extends('layouts.pembangunan')

@section('title', 'Progres Proyek')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Riwayat Progres Proyek</h1>
        <p class="page-subtitle">Daftar riwayat pembaruan progres untuk setiap proyek.</p>
    </div>
    <a href="{{ route('pembangunan.progress.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Progres
    </a>
</div>

@if (session('success'))
    <div style="background: #ECFDF5; color: #10B981; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #A4F4CF;">
        {{ session('success') }}
    </div>
@endif

<div class="admin-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
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
                        <td>{{ ($progresses->firstItem() ?? 1) + $index }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->report_date)->format('d M Y') }}</td>
                        <td style="font-weight: 600;">{{ $item->project->project_code ?? '-' }}</td>
                        <td>{{ $item->project->name ?? '-' }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-weight: 600; font-size: 13px;">{{ $item->progress_percentage }}%</span>
                                <div style="flex: 1; height: 6px; background: #F1F5F9; border-radius: 3px; overflow: hidden; min-width: 80px;">
                                    <div style="height: 100%; width: {{ $item->progress_percentage }}%; background: {{ $item->progress_percentage == 100 ? 'var(--admin-success)' : 'var(--admin-primary)' }};"></div>
                                </div>
                            </div>
                        </td>
                        <td>Rp {{ number_format($item->realized_budget, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--admin-text-muted); padding: 32px 0;">Belum ada data riwayat progres proyek.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $progresses->links() }}
    </div>
</div>
@endsection
