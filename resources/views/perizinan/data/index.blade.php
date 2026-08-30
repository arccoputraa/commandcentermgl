@extends('layouts.perizinan')

@section('title', 'Daftar Data Perizinan')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }
    .page-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
    }
    .page-title p {
        color: #64748B;
        font-size: 14px;
    }
    .btn-primary-custom {
        background: #2563EB;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }
    .btn-primary-custom:hover {
        background: #1D4ED8;
    }
    
    .data-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .search-box {
        position: relative;
        max-width: 400px;
        margin-bottom: 20px;
    }
    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
    }
    .search-box input {
        width: 100%;
        padding: 10px 14px 10px 36px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 14px;
        color: #334155;
    }
    
    .table-container {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    th {
        text-align: left;
        padding: 14px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #F1F5F9;
        background: #F8FAFC;
    }
    th:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
    th:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
    
    td {
        padding: 16px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-disetujui { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
    .status-proses { background: #FEFCE8; color: #CA8A04; border: 1px solid #FEF08A; }
    .status-ditolak { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
    
    .action-btns {
        display: flex;
        gap: 8px;
    }
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        background: transparent;
    }
    .btn-edit { color: #2563EB; }
    .btn-edit:hover { background: #EFF6FF; }
    .btn-delete { color: #DC2626; }
    .btn-delete:hover { background: #FEF2F2; }
    
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        font-size: 14px;
        color: #64748B;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Daftar Data Perizinan</h1>
        <p>Kelola data perizinan, rekapitulasi data perizinan secara mendetail.</p>
    </div>
    <a href="{{ route('perizinan.data.create') }}" class="btn-primary-custom" style="text-decoration: none;">
        <i class="fa-solid fa-plus"></i> Tambah Data
    </a>
</div>

@if(session('success'))
    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; color: #16A34A; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<div class="data-card">
    <div class="search-box">
        <i class="fa-solid fa-search"></i>
        <input type="text" placeholder="Cari No Dokumen atau Nama Pemohon...">
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NO DOKUMEN</th>
                    <th>NAMA PEMOHON</th>
                    <th>JENIS IZIN</th>
                    <th>JENIS PERMOHONAN</th>
                    <th>TANGGAL</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td style="font-weight: 600; color: #0F172A;">{{ $item->no_dokumen }}</td>
                    <td>{{ $item->nama_pemohon }}</td>
                    <td>{{ $item->jenisIzin->kategori ?? '-' }}</td>
                    <td>{{ $item->jenis_permohonan }}</td>
                    <td>{{ $item->tanggal->format('d M Y') }}</td>
                    <td>
                        @php
                            $badgeClass = 'status-proses';
                            if(strtolower($item->status) == 'disetujui') $badgeClass = 'status-disetujui';
                            if(strtolower($item->status) == 'ditolak') $badgeClass = 'status-ditolak';
                        @endphp
                        <span class="status-badge {{ $badgeClass }}">{{ $item->status }}</span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('perizinan.data.edit', $item->id) }}" class="btn-icon btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button class="btn-icon btn-delete" onclick="openModal('delete', {{ $item }})"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94A3B8;">Belum ada data perizinan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $data->links() }}
</div>

<!-- Modal Delete -->
<div class="modal-backdrop" id="modalDelete">
    <div class="modal-container" style="max-width: 400px; text-align: center; padding: 32px 24px;">
        <div style="width: 64px; height: 64px; background: #FEF2F2; color: #DC2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px;">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 style="font-size: 20px; font-weight: 700; color: #1E293B; margin-bottom: 8px;">Hapus Data</h3>
        <p style="color: #64748B; margin-bottom: 24px;">Apakah Anda yakin ingin menghapus data perizinan <span id="delNoDokumen" style="font-weight: 600; color: #0F172A;"></span>?</p>
        
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closeModal('modalDelete')" style="padding: 10px 24px; background: #F1F5F9; color: #475569; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Batal</button>
                <button type="submit" style="padding: 10px 24px; background: #DC2626; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Hapus</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openModal(type, data = null) {
        if (type === 'delete') {
            document.getElementById('delNoDokumen').innerText = data.no_dokumen;
            document.getElementById('deleteForm').action = "/perizinan/data/" + data.id;
            document.getElementById('modalDelete').classList.add('show');
        }
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }
</script>
@endpush
