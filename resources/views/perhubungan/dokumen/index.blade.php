@extends('layouts.perhubungan')

@section('title', 'Dokumen Laporan')

@push('styles')
<style>
    /* Gunakan style yang sama dengan ujikir */
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
        <h1>Dokumen Laporan Perhubungan</h1>
        <p>Manajemen file dokumen dan laporan kinerja (PDF).</p>
    </div>
    <button onclick="openModal('add')" class="btn-primary-custom">
        <i class="fa-solid fa-plus"></i> Upload Dokumen
    </button>
</div>

<div class="data-card">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>JUDUL DOKUMEN</th>
                    <th>TAG</th>
                    <th>TANGGAL RILIS</th>
                    <th>FILE</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokumen as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->judul }}</td>
                    <td>{{ $item->status_tag }}</td>
                    <td>{{ optional($item->tanggal_rilis)->format('d M Y') ?? '-' }}</td>
                    <td><a href="{{ Storage::url($item->file_path) }}" target="_blank" style="color: #2563EB; text-decoration: none;"><i class="fa-solid fa-file-pdf"></i> Lihat File</a></td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-icon btn-edit" onclick="openModal('edit', {{ $item }})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form action="{{ route('perhubungan.dokumen.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus dokumen ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center; color: #94A3B8;">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="modalForm">
    <div class="modal-container" style="max-width: 500px;">
        <h3 id="modalTitle" style="margin-bottom: 20px;">Upload Dokumen Baru</h3>
        <form id="formDokumen" method="POST" action="{{ route('perhubungan.dokumen.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Judul Dokumen</label>
                <input type="text" name="judul" id="judul" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">File PDF (Kosongi jika tidak ingin diubah saat edit)</label>
                <input type="file" name="file_dokumen" id="file_dokumen" accept="application/pdf" style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Tag / Kategori</label>
                <input type="text" name="status_tag" id="status_tag" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;" placeholder="Misal: Laporan Bulanan">
            </div>
            <div style="margin-bottom: 24px;">
                <label style="display:block; margin-bottom:8px; font-weight:500;">Tanggal Rilis</label>
                <input type="date" name="tanggal_rilis" id="tanggal_rilis" required style="width:100%; padding:10px; border:1px solid #E2E8F0; border-radius:6px;">
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
        let form = document.getElementById('formDokumen');
        if (type === 'edit') {
            document.getElementById('modalTitle').innerText = 'Edit Dokumen';
            form.action = `/admin/perhubungan/dokumen/${data.id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('file_dokumen').required = false;
            
            document.getElementById('judul').value = data.judul;
            document.getElementById('status_tag').value = data.status_tag;
            document.getElementById('tanggal_rilis').value = data.tanggal_rilis.split('T')[0];
        } else {
            document.getElementById('modalTitle').innerText = 'Upload Dokumen Baru';
            form.action = `{{ route('perhubungan.dokumen.store') }}`;
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('file_dokumen').required = true;
            form.reset();
        }
        document.getElementById('modalForm').classList.add('show');
    }
    function closeModal() { document.getElementById('modalForm').classList.remove('show'); }
</script>
@endsection
