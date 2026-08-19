@extends('layouts.kesehatan')

@section('title', 'Informasi Terbaru')

@push('styles')
<style>
    .page-header {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .page-title-sub {
        font-size: 12px;
        font-weight: 700;
        color: #10B981;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }
    .btn-add {
        background: #009966;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .btn-add:hover {
        background: #008055;
    }

    .info-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .info-card-header {
        padding: 24px;
        border-bottom: 1px solid #F1F5F9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .info-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 4px;
    }
    .info-card-subtitle {
        font-size: 13px;
        color: #64748B;
    }
    .badge-count {
        background: #ECFDF5;
        color: #10B981;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid #A7F3D0;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table th {
        background: #F8FAFC;
        padding: 12px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }
    .info-table tr:last-child td {
        border-bottom: none;
    }
    .col-judul {
        font-weight: 600;
        color: #1E293B;
        font-size: 14px;
    }
    .pdf-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #FEF2F2;
        color: #EF4444;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
    }
    .col-update {
        color: #94A3B8;
        font-size: 13px;
    }
    .action-buttons {
        display: flex;
        gap: 16px;
    }
    .btn-icon {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        transition: color 0.2s;
    }
    .btn-edit { color: #F59E0B; }
    .btn-edit:hover { color: #D97706; }
    .btn-delete { color: #EF4444; }
    .btn-delete:hover { color: #DC2626; }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal.active {
        display: flex;
    }
    .modal-content {
        background: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .modal-header {
        padding: 24px;
        border-bottom: 1px solid #F1F5F9;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .modal-title-box h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1E293B;
        margin: 0 0 4px 0;
    }
    .modal-title-box p {
        font-size: 13px;
        color: #64748B;
        margin: 0;
    }
    .btn-close {
        background: none;
        border: none;
        color: #94A3B8;
        cursor: pointer;
        font-size: 20px;
        padding: 0;
    }
    .btn-close:hover {
        color: #475569;
    }
    .modal-body {
        padding: 24px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 14px;
        color: #1E293B;
    }
    .form-control:focus {
        outline: none;
        border-color: #009966;
        box-shadow: 0 0 0 3px rgba(0,153,102,0.1);
    }
    .file-upload-help {
        font-size: 12px;
        color: #64748B;
        margin-top: 8px;
        display: block;
    }
    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #F1F5F9;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .btn-cancel {
        background: #fff;
        border: 1px solid #E2E8F0;
        color: #475569;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-cancel:hover {
        background: #F8FAFC;
    }
    .btn-save {
        background: #009966;
        color: white;
        border: none;
        padding: 8px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-save:hover {
        background: #008055;
    }
    .btn-danger {
        background: #FEF2F2;
        color: #EF4444;
        border: none;
        padding: 8px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-danger:hover {
        background: #FEE2E2;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <div class="page-title-sub">PUBLIKASI KESEHATAN</div>
        <h1 class="page-title">Informasi Terbaru</h1>
    </div>
    <button class="btn-add" onclick="openModal('addModal')">
        <i class="fa-solid fa-plus"></i> Tambah Informasi
    </button>
</div>

@if(session('success'))
    <div style="background: #ECFDF5; color: #10B981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background: #FEF2F2; color: #EF4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="info-card">
    <div class="info-card-header">
        <div>
            <div class="info-card-title">Daftar Informasi PDF</div>
            <div class="info-card-subtitle">Hanya file .pdf yang digunakan sebagai dokumen publik.</div>
        </div>
        <div class="badge-count">{{ $informasi->count() }} Dokumen</div>
    </div>
    
    <table class="info-table">
        <thead>
            <tr>
                <th>JUDUL</th>
                <th>FILE PDF</th>
                <th>UPDATE</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($informasi as $item)
            <tr>
                <td class="col-judul">{{ $item->judul }}</td>
                <td>
                    <div class="pdf-badge">
                        <i class="fa-regular fa-file-pdf"></i>
                        {{ $item->file_pdf }}
                    </div>
                </td>
                <td class="col-update">
                    @php
                        $days = (int) \Carbon\Carbon::parse($item->updated_at)->startOfDay()->diffInDays(now()->startOfDay());
                    @endphp
                    @if($days == 0)
                        Hari ini
                    @else
                        {{ $days }} hari lalu
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->judul) }}', '{{ $item->file_pdf }}')">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="btn-icon btn-delete" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->judul) }}')">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 40px; color: #64748B;">
                    Belum ada informasi terbaru.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal" id="formModal">
    <div class="modal-content">
        <form action="{{ route('kesehatan.informasi.store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <div class="modal-title-box">
                    <h3>Tambah / Edit Informasi</h3>
                    <p>Isi judul dan unggah dokumen PDF.</p>
                </div>
                <button type="button" class="btn-close" onclick="closeModal('formModal')">
                    <i class="fa-regular fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" class="form-control" required placeholder="Contoh: Publikasi Data Kesehatan Triwulan III">
                </div>
                <div class="form-group">
                    <label for="file_pdf">Upload File PDF</label>
                    <input type="file" id="file_pdf" name="file_pdf" class="form-control" accept=".pdf">
                    <span class="file-upload-help" id="file_help">Format yang diperbolehkan: .pdf only.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('formModal')">Batal</button>
                <button type="submit" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal" id="deleteModal">
    <div class="modal-content" style="max-width: 450px;">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-body" style="padding: 32px 24px;">
                <h3 style="font-size: 18px; font-weight: 700; color: #1E293B; margin: 0 0 12px 0;">Hapus Informasi?</h3>
                <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.5;">
                    Dokumen <strong id="deleteJudul" style="color: #1E293B;"></strong> tidak akan tampil lagi pada Informasi Terbaru masyarakat.
                </p>
            </div>
            <div class="modal-footer" style="justify-content: flex-end; border-top: none; padding-top: 0;">
                <button type="button" class="btn-cancel" onclick="closeModal('deleteModal')">Batal</button>
                <button type="submit" class="btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(id) {
        if(id === 'addModal') {
            document.getElementById('mainForm').action = "{{ route('kesehatan.informasi.store') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('judul').value = "";
            document.getElementById('file_pdf').required = true;
            document.getElementById('file_help').textContent = "Format yang diperbolehkan: .pdf only.";
            
            document.getElementById('formModal').classList.add('active');
        }
    }

    function openEditModal(id, judul, fileName) {
        document.getElementById('mainForm').action = "/kesehatan/informasi/" + id;
        document.getElementById('formMethod').value = "PUT";
        document.getElementById('judul').value = judul;
        document.getElementById('file_pdf').required = false;
        document.getElementById('file_help').innerHTML = "Format yang diperbolehkan: .pdf only. Terpilih: <strong>" + fileName + "</strong>";
        
        document.getElementById('formModal').classList.add('active');
    }

    function openDeleteModal(id, judul) {
        document.getElementById('deleteForm').action = "/kesehatan/informasi/" + id;
        document.getElementById('deleteJudul').textContent = judul;
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }
</script>
@endpush
