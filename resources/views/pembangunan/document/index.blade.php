@extends('layouts.pembangunan')

@section('title', 'Dokumen Proyek')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Manajemen Dokumen Proyek</h1>
        <p class="page-subtitle">Kelola dokumen, laporan, dan gambar terkait proyek pembangunan.</p>
    </div>
    <a href="{{ route('pembangunan.document.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Upload Dokumen
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
                    <th>Proyek Terkait</th>
                    <th>Judul Dokumen</th>
                    <th>Tipe</th>
                    <th>Tanggal Upload</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $d)
                <tr>
                    <td style="font-weight: 600;">{{ $d->project ? $d->project->name : 'N/A' }}</td>
                    <td>{{ $d->title }}</td>
                    <td>
                        <span class="status-badge" style="background: {{ $d->type == 'PDF' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(59, 130, 246, 0.1)' }}; color: {{ $d->type == 'PDF' ? 'var(--admin-danger)' : 'var(--admin-primary)' }};">
                            {{ $d->type }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($d->upload_date)->format('d/m/Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            @if($d->file_path)
                                <a href="{{ asset($d->file_path) }}" target="_blank" class="btn btn-outline btn-sm" style="color: var(--admin-text-muted); border-color: var(--admin-border);">
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                            @endif
                            <a href="{{ route('pembangunan.document.edit', $d->id) }}" class="btn btn-outline btn-sm" style="color: var(--admin-primary); border-color: var(--admin-primary);">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('pembangunan.document.destroy', $d->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus dokumen ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--admin-text-muted); padding: 32px 0;">Belum ada dokumen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $documents->links() }}
    </div>
</div>
@endsection
