@extends('layouts.admin')

@section('title', 'Daftar Divisi/Sektor')
@section('page_title', 'Daftar Divisi/Sektor')
@section('page_subtitle', 'Kelola departemen yang tergabung dalam Command Center.')

@section('content')
<div class="table-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div class="search-wrapper" style="width: 320px;">
            <i class="fa-solid fa-search"></i>
            <input type="text" class="search-input" placeholder="Cari nama divisi/sektor...">
        </div>
        <button class="btn btn-primary" onclick="openDivisionModal('create')">
            <i class="fa-solid fa-plus"></i> Tambah Divisi
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
                <th>NO.</th>
                <th>NAMA DIVISI</th>
                <th>DESKRIPSI</th>
                <th>PENGGUNA</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($divisions as $index => $division)
                <tr>
                    <td>{{ $divisions->firstItem() + $index }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: #EFF6FF; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-building" style="color: #155DFC; font-size: 14px;"></i>
                            </div>
                            <span style="font-weight: 600; color: #1D293D;">{{ $division->name }}</span>
                        </div>
                    </td>
                    <td><span style="color: #62748E; font-size: 14px;">{{ $division->description ?: 'Tidak ada deskripsi' }}</span></td>
                    <td><span style="font-weight: 500; color: #314158;">{{ $division->users_count }} user</span></td>
                    <td>
                        <span class="badge-status" style="{{ strtolower($division->status) === 'aktif' ? '' : 'background: rgba(238, 93, 80, 0.1); color: var(--admin-danger); border-color: var(--admin-danger);' }}">
                            {{ ucfirst($division->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-outline btn-sm" onclick="openDivisionModal('detail', '{{ $division->id }}', '{{ $division->name }}', '{{ $division->description }}', '{{ $division->users_count }}', '{{ ucfirst($division->status) }}', '{{ ucfirst($division->type) }}')"><i class="fa-solid fa-eye"></i></button>
                        <button class="btn btn-outline btn-sm" onclick="openDivisionModal('edit', '{{ $division->id }}', '{{ $division->name }}', '{{ $division->description }}', '{{ $division->users_count }}', '{{ ucfirst($division->status) }}', '{{ ucfirst($division->type) }}')"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-outline btn-sm" style="color: var(--admin-danger); border-color: var(--admin-danger);" onclick="openDivisionModal('delete', '{{ $division->id }}', '{{ $division->name }}')"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 24px; color: #62748E;">Belum ada data divisi/sektor.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $divisions->links() }}
    </div>
</div>
@endsection
