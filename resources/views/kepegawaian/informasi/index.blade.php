@extends('layouts.kepegawaian')

@section('title', 'Informasi Terbaru')

@section('content')
<div class="table-container" style="background:#fff; padding:24px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h3 style="margin:0; font-size:18px; color:#1e293b;">Daftar Informasi Terbaru</h3>
        <button onclick="openModal('modalAdd')" style="background:#2563eb; color:#fff; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:500;">
            <i class="fa-solid fa-plus"></i> Tambah Informasi
        </button>
    </div>

    <!-- Toolbar -->
    <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
        <form action="{{ route('kepegawaian.informasi.index') }}" method="GET" style="display:flex; gap:12px; width:400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau kategori..." style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; outline:none;">
            <button type="submit" style="background:#f1f5f9; border:1px solid #e2e8f0; padding:8px 16px; border-radius:6px; cursor:pointer;">Cari</button>
        </form>
    </div>

    <!-- Table -->
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <thead>
            <tr style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">JUDUL</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">KATEGORI</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">FORMAT</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">STATUS</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px; text-align:right;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($informasis as $info)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:12px; font-size:14px; font-weight:500; color:#0f172a;">{{ $info->judul }}</td>
                <td style="padding:12px; font-size:14px; color:#475569;">{{ $info->kategori }}</td>
                <td style="padding:12px; font-size:14px; color:#475569;">{{ $info->format ?? '-' }}</td>
                <td style="padding:12px; font-size:14px;">
                    @if($info->status_publikasi == 'Rilis')
                        <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Rilis</span>
                    @else
                        <span style="background:#f1f5f9; color:#475569; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Draft</span>
                    @endif
                </td>
                <td style="padding:12px; text-align:right;">
                    <a href="{{ route('kepegawaian.informasi.show', $info->id) }}" style="color:#3b82f6; text-decoration:none; margin-right:8px;"><i class="fa-solid fa-eye"></i></a>
                    <button onclick="openEditModal({{ $info->id }}, '{{ addslashes($info->judul) }}', '{{ $info->kategori }}', '{{ $info->format }}', '{{ $info->dokumen }}', '{{ $info->status_publikasi }}', '{{ addslashes($info->keterangan) }}')" style="background:none; border:none; color:#eab308; cursor:pointer; margin-right:8px;"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('kepegawaian.informasi.destroy', $info->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus informasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:24px; text-align:center; color:#94a3b8;">Tidak ada data informasi terbaru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div id="modalAdd" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:500px; border-radius:12px; padding:24px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
            <h3 style="margin:0;">Tambah Informasi Baru</h3>
            <button onclick="closeModal('modalAdd')" style="background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
        </div>
        <form action="{{ route('kepegawaian.informasi.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Judul Informasi</label>
                <input type="text" name="judul" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Kategori</label>
                <input type="text" name="kategori" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            <div style="display:flex; gap:12px; margin-bottom:12px;">
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Format (mis. PDF)</label>
                    <input type="text" name="format" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Status Publikasi</label>
                    <select name="status_publikasi" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                        <option value="Rilis">Rilis</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Tautan Dokumen / File</label>
                <input type="text" name="dokumen" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Keterangan</label>
                <textarea name="keterangan" rows="3" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px; resize:vertical;"></textarea>
            </div>
            <div style="text-align:right;">
                <button type="button" onclick="closeModal('modalAdd')" style="background:#f1f5f9; color:#475569; border:none; padding:8px 16px; border-radius:6px; cursor:pointer; margin-right:8px;">Batal</button>
                <button type="submit" style="background:#2563eb; color:#fff; border:none; padding:8px 16px; border-radius:6px; cursor:pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:500px; border-radius:12px; padding:24px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
            <h3 style="margin:0;">Edit Informasi</h3>
            <button onclick="closeModal('modalEdit')" style="background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Judul Informasi</label>
                <input type="text" name="judul" id="edit_judul" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Kategori</label>
                <input type="text" name="kategori" id="edit_kategori" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            <div style="display:flex; gap:12px; margin-bottom:12px;">
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Format (mis. PDF)</label>
                    <input type="text" name="format" id="edit_format" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Status Publikasi</label>
                    <select name="status_publikasi" id="edit_status" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                        <option value="Rilis">Rilis</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Tautan Dokumen / File</label>
                <input type="text" name="dokumen" id="edit_dokumen" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Keterangan</label>
                <textarea name="keterangan" id="edit_keterangan" rows="3" style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px; resize:vertical;"></textarea>
            </div>
            <div style="text-align:right;">
                <button type="button" onclick="closeModal('modalEdit')" style="background:#f1f5f9; color:#475569; border:none; padding:8px 16px; border-radius:6px; cursor:pointer; margin-right:8px;">Batal</button>
                <button type="submit" style="background:#2563eb; color:#fff; border:none; padding:8px 16px; border-radius:6px; cursor:pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    function openEditModal(id, judul, kategori, format, dokumen, status, keterangan) {
        document.getElementById('editForm').action = '/kepegawaian/informasi/' + id;
        document.getElementById('edit_judul').value = judul;
        document.getElementById('edit_kategori').value = kategori;
        document.getElementById('edit_format').value = format;
        document.getElementById('edit_dokumen').value = dokumen;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_keterangan').value = keterangan;
        openModal('modalEdit');
    }
</script>
@endsection
