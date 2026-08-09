@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 class="page-title" style="margin-bottom: 0;">Daftar Pengguna</h1>
        <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Pengguna</button>
    </div>

    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP / Username</th>
                    <th>Divisi</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->nip ?? $user->email }}</td>
                    <td>{{ $user->division->name ?? '-' }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <span class="status-badge {{ $user->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-outline btn-sm"><i class="fa-solid fa-eye"></i></button>
                        <button class="btn btn-outline btn-sm"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-outline btn-sm" style="color: var(--admin-danger); border-color: var(--admin-danger);"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--admin-text-muted);">Tidak ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 24px;">
            {{ $users->links() }}
        </div>
    </div>
@endsection
