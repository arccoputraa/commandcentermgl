@extends('layouts.sig')

@section('title', 'Data Spasial')

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
    .action-btns { display: flex; gap: 8px; }
    .btn-icon { width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; background: transparent; }
    .btn-edit { color: #2563EB; }
    .btn-delete { color: #DC2626; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Data Spasial</h1>
        <p>Input data titik koordinat untuk divisualisasikan di peta publik.</p>
    </div>
    <button onclick="openModal('add')" class="btn-primary-custom">
        <i class="fa-solid fa-plus"></i> Tambah Data Spasial
    </button>
</div>

<div class="data-card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>NAMA DATA</th>
                    <th>LAYER</th>
                    <th>KATEGORI</th>
                    <th>WILAYAH</th>
                    <th>JUMLAH</th>
                    <th>KOORDINAT</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataSpasial as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->nama_data }}</td>
                    <td><span style="background: #F1F5F9; padding: 4px 10px; border-radius: 6px; font-size:12px;">{{ $item->layer->nama_layer ?? '-' }}</span></td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->wilayah }}</td>
                    <td>{{ number_format($item->nilai_jumlah) }}</td>
                    <td style="font-size: 12px; color: #64748B;">Lat: {{ $item->latitude }}<br>Lng: {{ $item->longitude }}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick="openModal('edit', {{ $item }})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form action="{{ route('sig.data-spasial.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data spasial ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align: center; color: #94A3B8;">Belum ada data spasial.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="modalForm">
    <div class="modal-container" style="max-width: 600px;">
        <h3 id="modalTitle" style="margin-bottom: 20px;">Tambah Data Spasial</h3>
        <form id="formDataSpasial" method="POST" action="{{ route('sig.data-spasial.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:500;">Nama Data</label>
                    <input type="text" name="nama_data" id="nama_data" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:500;">Layer</label>
                    <select name="layer_id" id="layer_id" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
                        <option value="">-- Pilih Layer --</option>
                        @foreach($layers as $layer)
                            <option value="{{ $layer->id }}">{{ $layer->nama_layer }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:500;">Kategori</label>
                    <input type="text" name="kategori" id="kategori" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:500;">Wilayah (Kec/Kel)</label>
                    <input type="text" name="wilayah" id="wilayah" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Nilai / Jumlah</label>
                <input type="number" name="nilai_jumlah" id="nilai_jumlah" value="0" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; padding: 12px; background: #F8FAFC; border-radius: 8px;">
                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:500; font-size:13px; color:#64748B;">Latitude</label>
                    <input type="number" step="0.0000001" name="latitude" id="latitude" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;" placeholder="-7.4705">
                </div>
                <div>
                    <label style="display:block; margin-bottom:8px; font-weight:500; font-size:13px; color:#64748B;">Longitude</label>
                    <input type="number" step="0.0000001" name="longitude" id="longitude" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;" placeholder="110.2178">
                </div>
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
        let form = document.getElementById('formDataSpasial');
        if (type === 'edit') {
            document.getElementById('modalTitle').innerText = 'Edit Data Spasial';
            form.action = `/admin/sig/data-spasial/${data.id}`;
            document.getElementById('formMethod').value = 'PUT';
            
            document.getElementById('nama_data').value = data.nama_data;
            document.getElementById('layer_id').value = data.layer_id;
            document.getElementById('kategori').value = data.kategori;
            document.getElementById('wilayah').value = data.wilayah;
            document.getElementById('nilai_jumlah').value = data.nilai_jumlah;
            document.getElementById('latitude').value = data.latitude;
            document.getElementById('longitude').value = data.longitude;
        } else {
            document.getElementById('modalTitle').innerText = 'Tambah Data Spasial';
            form.action = `{{ route('sig.data-spasial.store') }}`;
            document.getElementById('formMethod').value = 'POST';
            form.reset();
        }
        document.getElementById('modalForm').classList.add('show');
    }
    function closeModal() { document.getElementById('modalForm').classList.remove('show'); }
</script>
@endsection
