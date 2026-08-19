@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 class="page-title" style="margin-bottom: 0;">Daftar Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Pengguna</a>
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
