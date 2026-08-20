@extends('layouts.pembangunan')

@section('title', 'Dokumen Proyek')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Dokumen Proyek</h1>
        <a href="{{ route('pembangunan.document.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Upload Dokumen
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
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
                            <td>{{ $d->project ? $d->project->name : 'N/A' }}</td>
                            <td>{{ $d->title }}</td>
                            <td>
                                <span class="badge badge-{{ $d->type == 'PDF' ? 'danger' : 'info' }}">
                                    {{ $d->type }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($d->upload_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($d->file_path)
                                    <a href="{{ asset($d->file_path) }}" target="_blank" class="btn btn-sm btn-secondary"><i class="fas fa-download"></i> Unduh</a>
                                @endif
                                <a href="{{ route('pembangunan.document.edit', $d->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('pembangunan.document.destroy', $d->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus dokumen ini?')"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada dokumen.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
