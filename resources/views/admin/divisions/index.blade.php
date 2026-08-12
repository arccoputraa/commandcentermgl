@extends('layouts.admin')

@section('content')
<style>
    .divisions-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .divisions-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px 0;
    }
    .divisions-subtitle {
        color: #64748b;
        margin: 0;
        font-size: 15px;
    }
    .btn-add-division {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .btn-add-division:hover {
        background: #1d4ed8;
    }
    
    .table-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        font-family: 'Inter', sans-serif;
    }
    .table-toolbar {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        gap: 12px;
    }
    .search-input-wrapper {
        position: relative;
        flex-grow: 1;
        max-width: 600px;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    .search-input-wrapper input {
        width: 100%;
        padding: 10px 16px 10px 44px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
        color: #334155;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .search-input-wrapper input:focus {
        border-color: #2563eb;
    }
    .filter-btn {
        width: 42px;
        height: 42px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #64748b;
        transition: background 0.2s;
    }
    .filter-btn:hover {
        background: #f8fafc;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }
    .custom-table th {
        text-transform: uppercase;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        padding: 16px 24px;
        text-align: left;
        background: #f8fafc;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f1f5f9;
    }
    .custom-table td {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 14px;
    }
    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }
    .custom-table tbody tr:hover {
        background: #f8fafc;
    }
    
    .division-name-col {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .division-icon {
        width: 36px;
        height: 36px;
        background: #eff6ff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        font-size: 16px;
    }
    .division-name-text {
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
    }
    .desc-text {
        color: #64748b;
    }
    .users-text {
        color: #475569;
    }
    
    .status-badge-custom {
        display: inline-block;
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .status-badge-custom.nonaktif {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .action-btns {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .action-btn {
        background: transparent;
        border: none;
        padding: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: opacity 0.2s;
    }
    .action-btn:hover {
        opacity: 0.7;
    }
    .action-view { color: #3b82f6; }
    .action-edit { color: #f59e0b; }
    .action-delete { color: #ef4444; }

    .pagination-wrapper {
        padding: 20px 24px;
        border-top: 1px solid #f1f5f9;
    }
</style>

@if(session('success'))
    <div style="background: #ECFDF5; border: 1px solid #A4F4CF; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; color: #009966; font-family: 'Inter', sans-serif;">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div style="background: #FEF2F2; border: 1px solid #FECACA; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; color: #E7000B; font-family: 'Inter', sans-serif;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="divisions-header">
    <div>
        <h1 class="divisions-title">Daftar Divisi/Sektor</h1>
        <p class="divisions-subtitle">Kelola departemen yang tergabung dalam Command Center.</p>
    </div>
    <button class="btn-add-division" onclick="openDivisionModal('create')">
        <i class="fa-solid fa-plus"></i> Tambah Divisi
    </button>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <div class="search-input-wrapper">
            <i class="fa-solid fa-search"></i>
            <input type="text" placeholder="Cari divisi atau deskripsi...">
        </div>
        <button class="filter-btn">
            <!-- Kosong sesuai desain gambar, bisa diisi icon filter -->
        </button>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 25%;">NAMA DIVISI</th>
                <th style="width: 35%;">DESKRIPSI</th>
                <th style="width: 15%;">PENGGUNA</th>
                <th style="width: 10%;">STATUS</th>
                <th style="width: 10%;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @php
                $getIcon = function($name) {
                    $name = strtolower($name);
                    if (str_contains($name, 'perizinan')) return 'fa-regular fa-file-lines';
                    if (str_contains($name, 'kesehatan')) return 'fa-solid fa-heart-pulse';
                    if (str_contains($name, 'keuangan')) return 'fa-solid fa-wallet';
                    if (str_contains($name, 'kepegawaian')) return 'fa-solid fa-user-group';
                    if (str_contains($name, 'kependudukan')) return 'fa-solid fa-users';
                    if (str_contains($name, 'pembangunan')) return 'fa-solid fa-city';
                    if (str_contains($name, 'perhubungan')) return 'fa-solid fa-car';
                    if (str_contains($name, 'sig')) return 'fa-solid fa-map-location-dot';
                    return 'fa-regular fa-building';
                };
            @endphp
            
            @forelse($divisions as $index => $division)
                <tr>
                    <td style="color: #64748b;">{{ $divisions->firstItem() + $index }}</td>
                    <td>
                        <div class="division-name-col">
                            <div class="division-icon">
                                <i class="{{ $getIcon($division->name) }}"></i>
                            </div>
                            <span class="division-name-text">{{ $division->name }}</span>
                        </div>
                    </td>
                    <td><span class="desc-text">{{ $division->description ?: 'Tidak ada deskripsi' }}</span></td>
                    <td><span class="users-text">{{ $division->users_count }} user</span></td>
                    <td>
                        <span class="status-badge-custom {{ strtolower($division->status) === 'nonaktif' ? 'nonaktif' : '' }}">
                            {{ ucfirst($division->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn action-view" onclick="openDivisionModal('detail', '{{ $division->id }}', '{{ $division->name }}', '{{ $division->description }}', '{{ $division->users_count }}', '{{ ucfirst($division->status) }}', '{{ ucfirst($division->type) }}')">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="action-btn action-edit" onclick="openDivisionModal('edit', '{{ $division->id }}', '{{ $division->name }}', '{{ $division->description }}', '{{ $division->users_count }}', '{{ ucfirst($division->status) }}', '{{ ucfirst($division->type) }}')">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button class="action-btn action-delete" onclick="openDivisionModal('delete', '{{ $division->id }}', '{{ $division->name }}')">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 32px; color: #64748b;">Belum ada data divisi/sektor.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($divisions->hasPages())
    <div class="pagination-wrapper">
        {{ $divisions->links() }}
    </div>
    @endif
</div>
@endsection
