@extends('layouts.' . strtolower($division_slug))

@section('title', 'Edit User Divisi ' . $division->name)

@section('content')
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Edit User - {{ $user->name }}</h1>
            <p class="page-subtitle">Ubah informasi akun pengguna khusus divisi ini.</p>
        </div>
        <a href="{{ route('division.users.index', $division_slug) }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="admin-card" style="max-width: 800px;">
        <form action="{{ route('division.users.update', [$division_slug, $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label" for="nip">NIP / Username (Opsional)</label>
                    <input type="text" id="nip" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
                    @error('nip')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status Akun</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Hak Akses (Permissions)</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    @php
                        $availablePermissions = ['lihat_data', 'tambah_data', 'edit_data', 'hapus_data', 'kelola_publikasi', 'kelola_cctv'];
                        $userPermissions = $user->permissions ?? [];
                    @endphp
                    @foreach($availablePermissions as $perm)
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #334155; cursor: pointer;">
                            <input type="checkbox" name="permissions[]" value="{{ $perm }}" style="width: 16px; height: 16px;" {{ in_array($perm, $userPermissions) ? 'checked' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $perm)) }}
                        </label>
                    @endforeach
                </div>
            </div>

            <hr style="margin: 24px 0; border: 0; border-top: 1px solid #e2e8f0;">
            <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">Biarkan kosong jika tidak ingin mengubah password.</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label class="form-label" for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control">
                    @error('password')<span class="text-danger" style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div style="margin-top: 24px; text-align: right;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 24px;">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
