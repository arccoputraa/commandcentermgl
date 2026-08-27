@extends('layouts.pembangunan')

@section('title', 'Manajemen Proyek')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Manajemen Proyek Pembangunan</h1>
        <p class="page-subtitle">Daftar semua proyek pembangunan daerah yang terdata di sistem.</p>
    </div>
    <a href="{{ route('pembangunan.project.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Proyek
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
                    <th>Kode Proyek</th>
                    <th>Nama Proyek</th>
                    <th>Kategori</th>
                    <th>Kecamatan</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $p)
                <tr>
                    <td style="font-weight: 600;">{{ $p->project_code }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category }}</td>
                    <td>{{ $p->kecamatan }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-weight: 600; font-size: 13px;">{{ $p->progress_percentage }}%</span>
                            <div style="flex: 1; height: 6px; background: #F1F5F9; border-radius: 3px; overflow: hidden; min-width: 60px;">
                                <div style="height: 100%; width: {{ $p->progress_percentage }}%; background: {{ $p->progress_percentage == 100 ? 'var(--admin-success)' : 'var(--admin-primary)' }};"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($p->status == 'Selesai')
                            <span class="status-badge" style="background: rgba(16, 185, 129, 0.1); color: var(--admin-success);">Selesai</span>
                        @elseif($p->status == 'Berjalan')
                            <span class="status-badge" style="background: rgba(59, 130, 246, 0.1); color: var(--admin-primary);">Berjalan</span>
                        @else
                            <span class="status-badge" style="background: rgba(245, 158, 11, 0.1); color: var(--admin-warning);">Tertunda</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('pembangunan.project.edit', $p->id) }}" class="btn btn-outline btn-sm" style="color: var(--admin-primary); border-color: var(--admin-primary);">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('pembangunan.project.destroy', $p->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus proyek ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--admin-text-muted); padding: 32px 0;">Belum ada data proyek.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $projects->links() }}
    </div>
</div>
@endsection
