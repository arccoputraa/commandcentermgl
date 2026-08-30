@extends('layouts.perhubungan')

@section('title', 'Data Uji KIR')

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
    .status-lulus { background: #F0FDF4; color: #16A34A; }
    .status-tidak { background: #FEF2F2; color: #DC2626; }
    .status-ulang { background: #FFFBEB; color: #D97706; }
    .action-btns { display: flex; gap: 8px; }
    .btn-icon { width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; background: transparent; }
    .btn-edit { color: #2563EB; }
    .btn-delete { color: #DC2626; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Data Uji KIR</h1>
        <p>Manajemen data pengujian kendaraan bermotor.</p>
    </div>
    <button onclick="openModal('add')" class="btn-primary-custom">
        <i class="fa-solid fa-plus"></i> Tambah Data
    </button>
</div>

<div class="data-card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>TANGGAL UJI</th>
                    <th>JENIS KENDARAAN</th>
                    <th>STATUS UJI</th>
                    <th>UNIT LAYANAN</th>
                    <th>KETERANGAN</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ujiKir as $item)
                <tr>
                    <td>{{ optional($item->tanggal_uji)->format('d M Y') ?? '-' }}</td>
                    <td style="font-weight: 600;">{{ $item->jenis_kendaraan }}</td>
                    <td>
                        @php
                            $badge = 'status-ulang';
                            if($item->status_uji == 'Lulus Uji') $badge = 'status-lulus';
                            if($item->status_uji == 'Tidak Lulus') $badge = 'status-tidak';
                        @endphp
                        <span class="status-badge {{ $badge }}">{{ $item->status_uji }}</span>
                    </td>
                    <td>{{ $item->unit_layanan }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick="openModal('edit', {{ $item }})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form action="{{ route('perhubungan.ujikir.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align: center; color: #94A3B8;">Belum ada data uji KIR.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div class="modal-backdrop" id="modalForm">
    <div class="modal-container" style="max-width: 500px;">
        <h3 id="modalTitle" style="margin-bottom: 20px;">Tambah Data Uji KIR</h3>
        <form id="formUjiKir" method="POST" action="{{ route('perhubungan.ujikir.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Tanggal Uji</label>
                <input type="date" name="tanggal_uji" id="tanggal_uji" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Jenis Kendaraan</label>
                <input type="text" name="jenis_kendaraan" id="jenis_kendaraan" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;" placeholder="Misal: Bus Kecil, Truk Box">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Status Uji</label>
                <select name="status_uji" id="status_uji" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
                    <option value="Lulus Uji">Lulus Uji</option>
                    <option value="Tidak Lulus">Tidak Lulus</option>
                    <option value="Perlu Uji Ulang">Perlu Uji Ulang</option>
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Unit Layanan</label>
                <input type="text" name="unit_layanan" id="unit_layanan" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
            </div>
            <div style="margin-bottom: 24px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3" style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;"></textarea>
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
        let form = document.getElementById('formUjiKir');
        if (type === 'edit') {
            document.getElementById('modalTitle').innerText = 'Edit Data Uji KIR';
            form.action = `/admin/perhubungan/ujikir/${data.id}`;
            document.getElementById('formMethod').value = 'PUT';
            
            document.getElementById('tanggal_uji').value = data.tanggal_uji.split('T')[0];
            document.getElementById('jenis_kendaraan').value = data.jenis_kendaraan;
            document.getElementById('status_uji').value = data.status_uji;
            document.getElementById('unit_layanan').value = data.unit_layanan;
            document.getElementById('keterangan').value = data.keterangan;
        } else {
            document.getElementById('modalTitle').innerText = 'Tambah Data Uji KIR';
            form.action = `{{ route('perhubungan.ujikir.store') }}`;
            document.getElementById('formMethod').value = 'POST';
            form.reset();
        }
        document.getElementById('modalForm').classList.add('show');
    }

    function closeModal() {
        document.getElementById('modalForm').classList.remove('show');
    }
</script>
@endsection
