@extends('layouts.finance')

@section('title', 'Informasi Terbaru')

@section('content')
<style>
    .finance-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        font-family: 'Inter', sans-serif;
    }
    .header-text h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    .header-text p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    .btn-primary {
        background: #2563eb;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-primary:hover {
        background: #1d4ed8;
        color: #fff;
    }
    
    .toolbar-container {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        background: #ffffff;
        padding: 8px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        font-family: 'Inter', sans-serif;
    }
    .search-input-wrapper {
        flex-grow: 1;
        position: relative;
        display: flex;
        align-items: center;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 16px;
        color: #94a3b8;
    }
    .search-input-wrapper input {
        width: 100%;
        padding: 10px 16px 10px 44px;
        border-radius: 8px;
        background: transparent;
        border: none;
        outline: none;
        font-size: 14px;
        color: #334155;
    }
    
    .table-container {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow-x: auto;
        font-family: 'Inter', sans-serif;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background: #f8fafc;
        padding: 16px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    .data-table td:last-child {
        white-space: nowrap;
    }
    .data-table tr:last-child td {
        border-bottom: none;
    }

    .badge-status {
        display: inline-flex;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-rilis {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .badge-draft {
        background: #fef9c3;
        color: #854d0e;
        border: 1px solid #fef08a;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .btn-icon {
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 16px;
        padding: 4px;
        transition: transform 0.2s;
    }
    .btn-icon:hover {
        transform: scale(1.1);
    }
    .btn-view { color: #3b82f6; }
    .btn-edit { color: #eab308; }
    .btn-delete { color: #ef4444; }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.4);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        backdrop-filter: blur(4px);
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-card {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 600px;
        padding: 28px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transform: translateY(20px);
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        max-height: 90vh;
        overflow-y: auto;
    }
    .modal-overlay.active .modal-card {
        transform: translateY(0);
    }
    
    .modal-card.small {
        max-width: 400px;
        text-align: center;
        padding: 32px 24px;
    }
    
    .modal-header {
        margin-bottom: 24px;
    }
    .modal-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }
    .modal-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    .form-group.full-width {
        grid-column: span 2;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        color: #0f172a;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    textarea.form-control {
        min-height: 80px;
        resize: vertical;
    }
    
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
    }
    .btn-outline {
        background: transparent;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-outline:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .btn-danger {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-danger:hover {
        background: #fee2e2;
    }
</style>

<!-- Header -->
<div class="finance-header">
    <div class="header-text">
        <h2>Informasi Terbaru</h2>
        <p>Manajemen publikasi data, laporan, dan informasi keuangan terbaru.</p>
    </div>
    <button class="btn-primary" onclick="openModal('modalForm')">
        <i class="fa-solid fa-plus"></i> Tambah Informasi
    </button>
</div>

<!-- Alerts -->
@if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-family: 'Inter', sans-serif; font-size: 14px;">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-family: 'Inter', sans-serif; font-size: 14px;">
        <ul style="margin:0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Search Bar -->
<div class="toolbar-container">
    <form action="{{ route('finance.information.index') }}" method="GET" style="display:flex; width:100%; align-items:center; gap: 12px; margin:0;">
        <div class="search-input-wrapper">
            <i class="fa-solid fa-search"></i>
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
        </div>
        <div style="width: 1px; height: 32px; background: #e2e8f0;"></div>
        <button type="submit" class="btn-primary" style="margin-right: 4px;">
            Terapkan Filter
        </button>
    </form>
</div>

<!-- Table -->
<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>JUDUL PUBLIKASI</th>
                <th>KATEGORI</th>
                <th>FORMAT</th>
                <th>TANGGAL UPLOAD</th>
                <th>STATUS PUBLIKASI</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($informations as $index => $info)
                @php
                    $badgeClass = strtolower($info->status_publikasi) == 'rilis' ? 'badge-rilis' : 'badge-draft';
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 500; color: #1e293b;">{{ Str::limit($info->judul, 40) }}</td>
                    <td>{{ $info->kategori }}</td>
                    <td>{{ $info->format }}</td>
                    <td>{{ $info->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge-status {{ $badgeClass }}">
                            {{ $info->status_publikasi }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('finance.information.show', $info->id) }}" class="btn-icon btn-view"><i class="fa-solid fa-eye"></i></a>
                            <button class="btn-icon btn-edit" onclick="editData({{ $info->toJson() }})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-icon btn-delete" onclick="confirmDelete({{ $info->id }})"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 32px;">Belum ada informasi publikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Form (Tambah/Edit) -->
<div class="modal-overlay" id="modalForm">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="modalTitle">Edit Data</h3>
            <p>Isi semua kolom yang tersedia dengan data yang benar.</p>
        </div>
        <form id="infoForm" action="{{ route('finance.information.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">Judul Publikasi</label>
                    <input type="text" name="judul" id="judul" class="form-control" required placeholder="Contoh: Laporan Realisasi Anggaran">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" required placeholder="Contoh: Laporan Keuangan">
                </div>
                <div class="form-group">
                    <label class="form-label">Format</label>
                    <input type="text" name="format" id="format" class="form-control" required placeholder="Contoh: PDF, 2.4MB">
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Upload File / Dokumen</label>
                    <input type="text" name="dokumen" id="dokumen" class="form-control" placeholder="URL dokumen / path (dummy)">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Publikasi</label>
                    <select name="status_publikasi" id="status_publikasi" class="form-control" required>
                        <option value="Rilis">Rilis</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Tulis keterangan..."></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-outline" onclick="closeModal('modalForm')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal-overlay" id="modalDelete">
    <div class="modal-card small">
        <div class="modal-header" style="text-align: left;">
            <h3>Hapus Data?</h3>
            <p>konfirmasi aksi untuk data Informasi Terbaru.</p>
        </div>
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-footer" style="margin-top: 24px; justify-content: flex-end;">
                <button type="button" class="btn-outline" onclick="closeModal('modalDelete')">Batal</button>
                <button type="submit" class="btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

@endsection

@stack('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        
        if (id === 'modalForm' && !document.getElementById('infoForm').dataset.editing) {
            document.getElementById('modalTitle').innerText = 'Tambah Data';
            document.getElementById('infoForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('infoForm').action = '{{ route("finance.information.store") }}';
        }
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        if (id === 'modalForm') {
            document.getElementById('infoForm').dataset.editing = "";
        }
    }

    function editData(data) {
        document.getElementById('modalTitle').innerText = 'Edit Data';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('infoForm').action = `/keuangan/information/${data.id}`;
        document.getElementById('infoForm').dataset.editing = "true";
        
        document.getElementById('judul').value = data.judul;
        document.getElementById('kategori').value = data.kategori;
        document.getElementById('format').value = data.format;
        document.getElementById('status_publikasi').value = data.status_publikasi;
        document.getElementById('dokumen').value = data.dokumen || '';
        document.getElementById('keterangan').value = data.keterangan || '';
        
        openModal('modalForm');
    }

    function confirmDelete(id) {
        document.getElementById('deleteForm').action = `/keuangan/information/${id}`;
        openModal('modalDelete');
    }
</script>
