@extends('layouts.sig')

@section('title', 'Manajemen Layer')

@push('styles')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
    .page-title h1 { font-size: 24px; font-weight: 700; color: #1E293B; margin-bottom: 8px; }
    .page-title p { color: #64748B; font-size: 14px; }
    .btn-primary-custom { background: #2563EB; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; }
    .data-card { background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #F1F5F9; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    table { width: 100%; border-collapse: separate; border-spacing: 0; }
    th { text-align: left; padding: 14px 16px; font-size: 12px; font-weight: 600; color: #64748B; background: #F8FAFC; }
    td { padding: 16px; font-size: 14px; color: #334155; border-bottom: 1px solid #F1F5F9; }
    .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
    .status-aktif { background: #F0FDF4; color: #16A34A; }
    .status-nonaktif { background: #F1F5F9; color: #64748B; }
    .action-btns { display: flex; gap: 8px; }
    .btn-icon { width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; background: transparent; }
    .btn-edit { color: #2563EB; }
    .btn-delete { color: #DC2626; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Manajemen Layer SIG</h1>
        <p>Atur layer untuk pengelompokan data spasial di peta.</p>
    </div>
    <button onclick="openModal('add')" class="btn-primary-custom">
        <i class="fa-solid fa-plus"></i> Tambah Layer
    </button>
</div>

<div class="data-card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>NAMA LAYER</th>
                    <th>STATUS AKTIF</th>
                    <th>JUMLAH DATA</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($layers as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->nama_layer }}</td>
                    <td>
                        @if($item->status_aktif)
                            <span class="status-badge status-aktif">Aktif</span>
                        @else
                            <span class="status-badge status-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $item->dataSpasial ? $item->dataSpasial->count() : 0 }} Data</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick="openModal('edit', {{ $item }})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form action="{{ route('sig.layer.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Menghapus layer akan menghapus semua data spasial di dalamnya. Yakin?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; color: #94A3B8;">Belum ada layer.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="modalForm">
    <div class="modal-container" style="max-width: 500px;">
        <h3 id="modalTitle" style="margin-bottom: 20px;">Tambah Layer</h3>
        <form id="formLayer" method="POST" action="{{ route('sig.layer.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Nama Layer</label>
                <input type="text" name="nama_layer" id="nama_layer" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
            </div>
            <div style="margin-bottom: 24px;">
                <label style="display:flex; align-items:center; gap:8px; font-weight:500;">
                    <input type="checkbox" name="status_aktif" id="status_aktif" value="1" checked> Aktifkan Layer
                </label>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="padding: 10px 20px; background: #F1F5F9; border: none; border-radius: 6px; cursor: pointer;">Batal</button>
                <button type="submit" style="padding: 10px 20px; background: #2563EB; color: white; border: none; border-radius: 6px; cursor: pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(type, data = null) {
        let form = document.getElementById('formLayer');
        if (type === 'edit') {
            document.getElementById('modalTitle').innerText = 'Edit Layer';
            form.action = `/admin/sig/layer/${data.id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('nama_layer').value = data.nama_layer;
            document.getElementById('status_aktif').checked = data.status_aktif == 1;
        } else {
            document.getElementById('modalTitle').innerText = 'Tambah Layer';
            form.action = `{{ route('sig.layer.store') }}`;
            document.getElementById('formMethod').value = 'POST';
            form.reset();
            document.getElementById('status_aktif').checked = true;
        }
        document.getElementById('modalForm').classList.add('show');
    }
    function closeModal() { document.getElementById('modalForm').classList.remove('show'); }
</script>
@endsection
