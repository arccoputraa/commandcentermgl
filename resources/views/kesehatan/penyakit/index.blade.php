@extends('layouts.kesehatan')

@section('title', 'Data Penyakit')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
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
        text-decoration: none;
    }
    .btn-add:hover {
        background: #008055;
    }

    .card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 24px;
    }
    .card-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #1E293B;
    }
    .search-input-wrapper {
        position: relative;
        width: 300px;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
    }
    .search-input-wrapper input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        text-align: left;
        padding: 12px 16px;
        color: #64748B;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 1px solid #E2E8F0;
    }
    td {
        padding: 16px;
        color: #1E293B;
        font-size: 14px;
        border-bottom: 1px solid #F1F5F9;
        font-weight: 500;
    }
    
    .action-icons {
        display: flex;
        gap: 12px;
    }
    .action-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-view { color: #3B82F6; }
    .btn-edit-icon { color: #F59E0B; }
    .btn-delete-icon { color: #EF4444; }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Data Penyakit</h1>
    <button class="btn-add" onclick="openAddModal()">
        <i class="fa-solid fa-plus"></i> Tambah Penyakit
    </button>
</div>

@if(session('success'))
    <div style="background: #ECFDF5; color: #10B981; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #10B981;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header-flex">
        <div class="card-title">Daftar Penyakit</div>
        <div class="search-input-wrapper">
            <i class="fa-solid fa-search"></i>
            <input type="text" placeholder="Cari penyakit...">
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>PENYAKIT</th>
                <th>JUMLAH</th>
                <th>UPDATE TERAKHIR</th>
                <th style="text-align: right;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item['nama'] }}</td>
                <td>{{ number_format($item['jumlah']) }}</td>
                <td>{{ $item['update'] }}</td>
                <td>
                    <div class="action-icons" style="justify-content: flex-end;">
                        <a href="{{ route('kesehatan.penyakit.detail', $item['id']) }}" class="action-btn btn-view"><i class="fa-solid fa-eye"></i></a>
                        <button class="action-btn btn-edit-icon" onclick="openEditModal({{ json_encode($item) }})"><i class="fa-solid fa-pen"></i></button>
                        <button class="action-btn btn-delete-icon" onclick="openDeleteModal({{ $item['id'] }}, '{{ $item['nama'] }}')"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah/Edit -->
<div class="modal-backdrop" id="formModal">
    <div class="modal-container md">
        <h3 class="modal-title" id="formModalTitle">Tambah / Edit Data Penyakit</h3>
        <p class="modal-subtitle">Isi data wilayah dan jumlah kasus penyakit terkini.</p>
        
        <form id="penyakitForm" method="POST" action="{{ route('kesehatan.penyakit.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label class="form-label">Nama Penyakit</label>
                    <input type="text" name="nama" id="inputNama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="inputJumlah" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="inputTahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" id="inputBulan" class="form-control" required>
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Wilayah</label>
                    <input type="text" name="wilayah" id="inputWilayah" class="form-control" value="Semua" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" id="inputStatus" class="form-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('formModal')">Batal</button>
                <button type="submit" class="btn btn-primary" style="background: #009966; border: none;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal-backdrop" id="deleteModal">
    <div class="modal-container" style="width: 400px;">
        <h3 class="modal-title">Hapus Penyakit?</h3>
        <p class="modal-subtitle" style="margin-top: -16px; margin-bottom: 24px; color: #64748B;">
            Semua data <span id="deleteItemName" style="font-weight: 600;"></span> akan dihapus dari daftar penyakit dan Top 10 Penyakit.
        </p>
        
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-footer" style="margin-top: 0; padding-top: 0; border: none;">
                <button type="button" class="btn btn-outline" onclick="closeModal('deleteModal')">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function openAddModal() {
        document.getElementById('formModalTitle').innerText = 'Tambah Data Penyakit';
        document.getElementById('penyakitForm').action = "{{ route('kesehatan.penyakit.store') }}";
        document.getElementById('formMethod').value = 'POST';
        
        document.getElementById('inputNama').value = '';
        document.getElementById('inputJumlah').value = '';
        document.getElementById('inputTahun').value = '{{ date('Y') }}';
        document.getElementById('inputWilayah').value = 'Semua';
        document.getElementById('inputStatus').value = 'Aktif';
        
        openModal('formModal');
    }

    function openEditModal(item) {
        document.getElementById('formModalTitle').innerText = 'Edit Data Penyakit';
        document.getElementById('penyakitForm').action = "/kesehatan/penyakit/" + item.id;
        document.getElementById('formMethod').value = 'PUT';
        
        document.getElementById('inputNama').value = item.nama;
        document.getElementById('inputJumlah').value = item.jumlah;
        document.getElementById('inputTahun').value = item.tahun;
        document.getElementById('inputBulan').value = item.bulan;
        document.getElementById('inputWilayah').value = item.wilayah;
        document.getElementById('inputStatus').value = item.status;
        
        openModal('formModal');
    }

    function openDeleteModal(id, nama) {
        document.getElementById('deleteItemName').innerText = nama;
        document.getElementById('deleteForm').action = "/kesehatan/penyakit/" + id;
        openModal('deleteModal');
    }
</script>
@endpush
