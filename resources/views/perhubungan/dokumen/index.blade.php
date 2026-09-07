@extends('layouts.perhubungan')

@section('title', 'Dokumen Laporan')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1 class="page-title">Dokumen Laporan Perhubungan</h1>
        <p class="page-subtitle">Manajemen file dokumen dan laporan kinerja (PDF).</p>
    </div>
    <button onclick="openModal('add')" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Upload Dokumen
    </button>
</div>

<div class="admin-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
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
                    <td><span class="badge-status">{{ $item->status_tag }}</span></td>
                    <td>{{ optional($item->tanggal_rilis)->format('d M Y') ?? '-' }}</td>
                    <td><a href="{{ Storage::url($item->file_path) }}" target="_blank" style="color: var(--admin-primary); text-decoration: none;"><i class="fa-solid fa-file-pdf"></i> Lihat File</a></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button class="btn btn-sm btn-outline" style="color: var(--admin-primary); border-color: var(--admin-primary);" onclick="openModal('edit', {{ $item }})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <form action="{{ route('perhubungan.dokumen.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus dokumen ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline" style="color: var(--admin-danger); border-color: var(--admin-danger);"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center; color: var(--admin-text-muted);">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="modalForm">
    <div class="modal-container md">
        <h3 id="modalTitle" class="modal-title">Upload Dokumen Baru</h3>
        <form id="formDokumen" method="POST" action="{{ route('perhubungan.dokumen.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="form-group">
                <label class="form-label">Judul Dokumen</label>
                <input type="text" name="judul" id="judul" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">File PDF (Kosongi jika tidak ingin diubah saat edit)</label>
                <input type="file" name="file_dokumen" id="file_dokumen" accept="application/pdf" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Tag / Kategori</label>
                <input type="text" name="status_tag" id="status_tag" required class="form-control" placeholder="Misal: Laporan Bulanan">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Rilis</label>
                <input type="date" name="tanggal_rilis" id="tanggal_rilis" required class="form-control">
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
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
@endpush
@endsection
