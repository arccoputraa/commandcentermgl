@extends('layouts.admin')

@section('content')
<style>
    .edit-container {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 32px;
        margin-top: 16px;
        max-width: 800px;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 12px 16px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s;
        background: #ffffff;
    }
    .form-group input:focus, .form-group select:focus {
        border-color: #2563eb;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }
    .btn-update {
        background: #2563eb;
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-update:hover {
        background: #1d4ed8;
    }
    .btn-cancel {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-cancel:hover {
        background: #f8fafc;
    }
    
    .page-header-custom {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 8px;
        font-family: 'Inter', sans-serif;
    }
    .page-header-custom a {
        color: #64748b;
        font-size: 20px;
        text-decoration: none;
        margin-top: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        transition: background 0.2s;
    }
    .page-header-custom a:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .page-header-custom h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    .page-header-custom p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }
    .error-text {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
</style>

<div class="page-header-custom">
    <a href="{{ route('admin.users.index') }}"><i class="fa-solid fa-angle-left"></i></a>
    <div>
        <h1>Edit Pengguna</h1>
        <p>Ubah informasi pengguna</p>
    </div>
</div>

<div class="edit-container">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="nip">Username / NIP</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                @error('nip')<span class="error-text">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="division_id">Divisi</label>
                <select id="division_id" name="division_id">
                    <option value="">-- Pilih Divisi --</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ old('division_id', $user->division_id) == $division->id ? 'selected' : '' }}>
                            {{ $division->name }}
                        </option>
                    @endforeach
                </select>
                @error('division_id')<span class="error-text">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User Divisi</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('role')<span class="error-text">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')<span class="error-text">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-update">Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection
