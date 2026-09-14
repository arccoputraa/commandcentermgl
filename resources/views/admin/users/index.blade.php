@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 class="page-title" style="margin-bottom: 0;">Daftar Pengguna</h1>
        <div style="display: flex; gap: 12px; align-items: center;">
            <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 8px; margin: 0;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIP..." class="form-control" style="padding: 8px 12px; width: 250px; font-size: 14px; border-radius: 6px; border: 1px solid #cbd5e1; outline: none;">
                <button type="submit" class="btn btn-outline" style="padding: 8px 12px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; cursor: pointer;"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Pengguna</a>
        </div>
    </div>

    <div class="admin-card">
        <div style="overflow-x: auto;">
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
                        <td>
                            @if($user->division)
                                {{ $user->division->name }}
                            @else
                                <span style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #e2e8f0;">Global</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $roleName = 'User / Staff';
                                if ($user->role === 'admin') $roleName = 'Super Admin';
                                elseif ($user->role === 'division_admin') $roleName = 'Admin Divisi';
                            @endphp
                            <span style="font-weight: 500;">{{ $roleName }}</span>
                        </td>
                        <td>
                            <span class="status-badge {{ $user->status == 'aktif' ? 'aktif' : 'nonaktif' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-pen"></i></a>
                            <button class="btn btn-outline btn-sm" style="color: var(--admin-danger); border-color: var(--admin-danger);" onclick="openUserModal('delete', '{{ addslashes($user->name) }}', {{ $user->id }})"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--admin-text-muted);">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 24px;">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal-backdrop" id="modalDeleteUser">
        <div class="modal-container md">
            <form id="deleteUserForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <h3 class="modal-title" style="margin-bottom: 8px;">Hapus Pengguna?</h3>
                <p id="deleteUserSubtitle" class="modal-subtitle">Pengguna akan dihapus dari sistem.</p>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('modalDeleteUser')">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUserModal(type, name, id) {
            if (type === 'delete') {
                document.getElementById('deleteUserSubtitle').innerText = `Pengguna ${name} akan dihapus dari sistem.`;
                document.getElementById('deleteUserForm').action = `/admin/users/${id}`;
                openModal('modalDeleteUser');
            }
        }
    </script>
@endsection
