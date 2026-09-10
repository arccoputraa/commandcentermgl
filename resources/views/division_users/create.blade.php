@extends('layouts.' . strtolower($division_slug))

@section('title', 'Tambah User Divisi ' . $division->name)

@section('content')
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Tambah User Baru - {{ $division->name }}</h1>
            <p class="page-subtitle">Buat akun pengguna baru khusus untuk divisi ini.</p>
        </div>
        <a href="{{ route('division.users.index', $division_slug) }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="admin-card" style="max-width: 800px;">
        <form action="{{ route('division.users.store', $division_slug) }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label" for="nip">NIP / Username</label>
                    <input type="text" id="nip" name="nip" class="form-control" value="{{ old('nip') }}">
                    @error('nip')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Role Akun</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="division_admin" {{ old('role') == 'division_admin' ? 'selected' : '' }}>Admin Divisi</option>
                    </select>
                    @error('role')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label" for="status">Status Akun</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Hak Akses (Permissions)</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    @php
                        $availablePermissions = ['lihat_data', 'tambah_data', 'edit_data', 'hapus_data', 'kelola_publikasi'];
                        if (strtolower($division->name) === 'sig') {
                            $availablePermissions[] = 'kelola_cctv';
                        }
                    @endphp
                    @foreach($availablePermissions as $perm)
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #334155; cursor: pointer;">
                            <input type="checkbox" name="permissions[]" value="{{ $perm }}" style="width: 16px; height: 16px;">
                            {{ ucwords(str_replace('_', ' ', $perm)) }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-top: 24px; text-align: right;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 24px;">
                    <i class="fa-solid fa-save"></i> Simpan User
                </button>
            </div>
        </form>
    </div>
@endsection
