@extends('layouts.pembangunan')

@section('title', 'Manajemen Proyek')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Proyek Pembangunan</h1>
        <a href="{{ route('pembangunan.project.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Proyek
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Proyek</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
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
                            <td>{{ $p->project_code }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category }}</td>
                            <td>{{ $p->kecamatan }}</td>
                            <td>{{ $p->progress_percentage }}%</td>
                            <td>
                                <span class="badge badge-{{ $p->status == 'Selesai' ? 'success' : ($p->status == 'Berjalan' ? 'primary' : 'warning') }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('pembangunan.project.edit', $p->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('pembangunan.project.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus proyek ini?')"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data proyek.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
