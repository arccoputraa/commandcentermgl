@extends('layouts.' . strtolower($division_slug))

@section('title', 'Manajemen User Divisi ' . $division->name)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 class="page-title" style="margin-bottom: 0;">Manajemen User - {{ $division->name }}</h1>
        @if(Auth::user()->role !== 'user')
        <a href="{{ route('division.users.create', $division_slug) }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah User</a>
        @endif
    </div>

    @if(session('success'))
        <div style="padding: 16px; margin-bottom: 24px; border-radius: 8px; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>NIP</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nip ?? '-' }}</td>
                        <td>
                            @if($user->role === 'division_admin')
                                <span class="badge" style="background:#fef08a; color:#854d0e;">Admin Divisi</span>
                            @else
                                <span class="badge" style="background:#e0f2fe; color:#0284c7;">User</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status == 'aktif')
                                <span class="badge-status" style="background: #ecfdf5; color: #059669; border-color: #a7f3d0;">Aktif</span>
                            @else
                                <span class="badge-status" style="background: #fef2f2; color: #dc2626; border-color: #fecaca;">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            @if(Auth::user()->role !== 'user')
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('division.users.edit', [$division_slug, $user->id]) }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 12px;">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('division.users.destroy', [$division_slug, $user->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                            @else
                                <span class="badge" style="background:#f1f5f9; color:#64748b;">Hanya Lihat</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #64748b; padding: 24px;">
                            Belum ada data user untuk divisi ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
