@extends('layouts.finance')

@section('title', 'Pendapatan Daerah / PAD')

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
    .badge-berjalan {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .badge-melebihi-target {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
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
    .modal-footer.center {
        justify-content: center;
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

    /* Helper function for formatting numbers */
    .number-display {
        font-variant-numeric: tabular-nums;
    }
</style>

<!-- Header -->
<div class="finance-header">
    <div class="header-text">
        <h2>Pendapatan Daerah / PAD</h2>
        <p>Menu ini menjadi sumber Target PAD, Realisasi PAD, Persentase PAD, dan tren PAD.</p>
    </div>
    <button class="btn-primary" onclick="openModal('modalForm')">
        <i class="fa-solid fa-plus"></i> Tambah Data PAD
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
    <form action="{{ route('finance.pad.index') }}" method="GET" style="display:flex; width:100%; align-items:center; gap: 12px; margin:0;">
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
                <th>TAHUN</th>
                <th>SUMBER PENDAPATAN</th>
                <th>SUB BIDANG</th>
                <th>TARGET PAD</th>
                <th>REALISASI PAD</th>
                <th>PERSENTASE</th>
                <th>KETERANGAN</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pads as $index => $pad)
                @php
                    $badgeClass = 'badge-berjalan';
                    if (str_contains(strtolower($pad->status), 'melebihi target')) {
                        $badgeClass = 'badge-melebihi-target';
                    }
                    
                    if (!function_exists('formatLargeNumber')) {
                        function formatLargeNumber($number) {
                            if ($number >= 1000000000) {
                                return 'Rp' . str_replace('.0', '', number_format($number / 1000000000, 1, ',', '.')) . ' M';
                            } elseif ($number >= 1000000) {
                                return 'Rp' . str_replace('.0', '', number_format($number / 1000000, 1, ',', '.')) . ' Juta';
                            }
                            return 'Rp' . number_format($number, 0, ',', '.');
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pad->tahun }}</td>
                    <td>{{ $pad->sumber_pendapatan }}</td>
                    <td>{{ $pad->sub_bidang }}</td>
                    <td class="number-display">{{ formatLargeNumber($pad->target_pad) }}</td>
                    <td class="number-display">{{ formatLargeNumber($pad->realisasi_pad) }}</td>
                    <td>{{ $pad->persentase }}%</td>
                    <td>
                        <span class="badge-status {{ $badgeClass }}">
                            {{ $pad->status ?? 'Berjalan' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('finance.pad.show', $pad->id) }}" class="btn-icon btn-view"><i class="fa-solid fa-eye"></i></a>
                            <button class="btn-icon btn-edit" onclick="editData({{ $pad->toJson() }})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-icon btn-delete" onclick="confirmDelete({{ $pad->id }})"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: #94a3b8; padding: 32px;">Belum ada data PAD.</td>
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
        <form id="padForm" action="{{ route('finance.pad.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="tahun" class="form-control" required value="{{ date('Y') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Sumber Pendapatan</label>
                    <input type="text" name="sumber_pendapatan" id="sumber_pendapatan" class="form-control" required placeholder="Contoh: Pajak Daerah">
                </div>
                <div class="form-group">
                    <label class="form-label">Sub Bidang</label>
                    <input type="text" name="sub_bidang" id="sub_bidang" class="form-control" required placeholder="Contoh: Bidang Pajak">
                </div>
                <div class="form-group">
                    <label class="form-label">Target PAD (Rp)</label>
                    <input type="number" name="target_pad" id="target_pad" class="form-control" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Realisasi PAD (Rp)</label>
                    <input type="number" name="realisasi_pad" id="realisasi_pad" class="form-control" placeholder="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Periode</label>
                    <input type="text" name="periode" id="periode" class="form-control" placeholder="Juli 2026">
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Status / Keterangan</label>
                    <input type="text" name="status" id="status" class="form-control" placeholder="Berjalan">
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Catatan Internal</label>
                    <textarea name="catatan_internal" id="catatan_internal" class="form-control" placeholder="Tulis keterangan..."></textarea>
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
            <p>konfirmasi aksi untuk data Pendapatan Daerah / PAD.</p>
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
        
        if (id === 'modalForm' && !document.getElementById('padForm').dataset.editing) {
            document.getElementById('modalTitle').innerText = 'Tambah Data';
            document.getElementById('padForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('padForm').action = '{{ route("finance.pad.store") }}';
        }
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        if (id === 'modalForm') {
            document.getElementById('padForm').dataset.editing = "";
        }
    }

    function editData(data) {
        document.getElementById('modalTitle').innerText = 'Edit Data';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('padForm').action = `/keuangan/pad/${data.id}`;
        document.getElementById('padForm').dataset.editing = "true";
        
        document.getElementById('tahun').value = data.tahun;
        document.getElementById('sumber_pendapatan').value = data.sumber_pendapatan;
        document.getElementById('sub_bidang').value = data.sub_bidang;
        document.getElementById('target_pad').value = parseFloat(data.target_pad);
        document.getElementById('realisasi_pad').value = parseFloat(data.realisasi_pad);
        document.getElementById('periode').value = data.periode || '';
        document.getElementById('status').value = data.status || '';
        document.getElementById('catatan_internal').value = data.catatan_internal || '';
        
        openModal('modalForm');
    }

    function confirmDelete(id) {
        document.getElementById('deleteForm').action = `/keuangan/pad/${id}`;
        openModal('modalDelete');
    }
</script>
