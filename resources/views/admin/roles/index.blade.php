@extends('layouts.admin')

@section('title', 'Hak Akses Pengguna')
@section('page_title', 'Hak Akses Pengguna')
@section('page_subtitle', 'Kelola permission setiap pengguna dalam sistem.')

@section('content')
<div class="table-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div class="search-wrapper" style="width: 320px;">
            <i class="fa-solid fa-search"></i>
            <input type="text" class="search-input" placeholder="Cari nama pengguna...">
        </div>
        <button class="btn btn-primary" onclick="openRoleModal('create', '', '', '', '', '', '[]')">
            <i class="fa-solid fa-plus"></i> Tambah Hak Akses
        </button>
    </div>

    @if(session('success'))
        <div style="background: #ECFDF5; border: 1px solid #A4F4CF; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; color: #009966;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background: #FEF2F2; border: 1px solid #FECACA; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; color: #E7000B;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>NAMA PENGGUNA</th>
                <th>DIVISI</th>
                <th>ROLE</th>
                <th>HAK AKSES</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <span style="font-weight: 600; color: #1D293D;">{{ $user->name }}</span>
                    </td>
                    <td><span style="color: #62748E; font-size: 14px;">{{ $user->division->name ?? 'Tidak Ada' }}</span></td>
                    <td><span style="font-weight: 500; color: #314158;">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            @if(is_array($user->permissions) && count($user->permissions) > 0)
                                @foreach($user->permissions as $permission)
                                    <span class="badge-permission">{{ ucwords(str_replace('_', ' ', $permission)) }}</span>
                                @endforeach
                            @else
                                <span style="color: #94A3B8; font-size: 13px; font-style: italic;">Tidak ada hak akses khusus</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @php
                            $permissionsJson = is_array($user->permissions) ? json_encode($user->permissions) : '[]';
                        @endphp
                        <button class="btn btn-outline btn-sm" onclick="openRoleModal('detail', '{{ $user->name }}', '{{ $user->division->name ?? 'Tidak Ada' }}', '{{ ucfirst($user->role) }}', '{{ ucfirst($user->status) }}', '{{ $user->id }}', '{{ $permissionsJson }}')"><i class="fa-solid fa-eye"></i></button>
                        <button class="btn btn-outline btn-sm" onclick="openRoleModal('edit', '{{ $user->name }}', '{{ $user->division_id }}', '{{ $user->role }}', '{{ ucfirst($user->status) }}', '{{ $user->id }}', '{{ $permissionsJson }}')"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-outline btn-sm" style="color: var(--admin-danger); border-color: var(--admin-danger);" onclick="openRoleModal('delete', '{{ $user->name }}', '', '', '', '{{ $user->id }}', '[]')"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 24px; color: #62748E;">Belum ada pengguna terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
