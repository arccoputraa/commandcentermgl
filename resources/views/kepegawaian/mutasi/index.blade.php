@extends('layouts.kepegawaian')

@section('title', 'Mutasi & Pensiun')

@section('content')
<div class="table-container" style="background:#fff; padding:24px; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h3 style="margin:0; font-size:18px; color:#1e293b;">Data Mutasi & Pensiun</h3>
        <button onclick="openModal('modalAdd')" style="background:#2563eb; color:#fff; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; font-weight:500;">
            <i class="fa-solid fa-plus"></i> Tambah Pengajuan
        </button>
    </div>

    <!-- Toolbar -->
    <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
        <form action="{{ route('kepegawaian.mutasi.index') }}" method="GET" style="display:flex; gap:12px; width:400px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIP, Nama atau Jenis..." style="width:100%; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px; outline:none;">
            <button type="submit" style="background:#f1f5f9; border:1px solid #e2e8f0; padding:8px 16px; border-radius:6px; cursor:pointer;">Cari</button>
        </form>
    </div>

    <!-- Table -->
    <table style="width:100%; border-collapse:collapse; text-align:left;">
        <thead>
            <tr style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">NIP</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">NAMA PEGAWAI</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">JENIS</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">TANGGAL EFEKTIF</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px;">STATUS</th>
                <th style="padding:12px; color:#64748b; font-weight:600; font-size:13px; text-align:right;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutasis as $m)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:12px; font-size:14px; color:#334155;">{{ $m->nip }}</td>
                <td style="padding:12px; font-size:14px; font-weight:500; color:#0f172a;">{{ $m->nama_pegawai }}</td>
                <td style="padding:12px; font-size:14px; color:#475569;">
                    @if($m->jenis == 'Mutasi')
                        <span style="background:#eff6ff; color:#1d4ed8; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Mutasi</span>
                    @else
                        <span style="background:#fff7ed; color:#c2410c; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Pensiun</span>
                    @endif
                </td>
                <td style="padding:12px; font-size:14px; color:#475569;">{{ date('d M Y', strtotime($m->tanggal_efektif)) }}</td>
                <td style="padding:12px; font-size:14px;">
                    @if($m->status_pengajuan == 'Disetujui')
                        <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Disetujui</span>
                    @elseif($m->status_pengajuan == 'Ditolak')
                        <span style="background:#fee2e2; color:#991b1b; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Ditolak</span>
                    @else
                        <span style="background:#fef08a; color:#854d0e; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:500;">Proses</span>
                    @endif
                </td>
                <td style="padding:12px; text-align:right;">
                    <button onclick="openEditModal({{ $m->id }}, '{{ $m->nip }}', '{{ $m->jenis }}', '{{ $m->tanggal_efektif }}', '{{ $m->status_pengajuan }}', '{{ addslashes($m->keterangan) }}')" style="background:none; border:none; color:#eab308; cursor:pointer; margin-right:8px;"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('kepegawaian.mutasi.destroy', $m->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus pengajuan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:24px; text-align:center; color:#94a3b8;">Tidak ada data mutasi/pensiun.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div id="modalAdd" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:500px; border-radius:12px; padding:24px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
            <h3 style="margin:0;">Tambah Pengajuan</h3>
            <button onclick="closeModal('modalAdd')" style="background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
        </div>
        <form action="{{ route('kepegawaian.mutasi.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Pegawai (NIP - Nama)</label>
                <select name="nip" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                    <option value="">-- Pilih Pegawai --</option>
                    @foreach($pegawais as $p)
                        <option value="{{ $p->nip }}">{{ $p->nip }} - {{ $p->nama }}</option>
                    @endforeach
                </select>
                <small style="color:#94a3b8; font-size:11px;">*Hanya data pegawai terdaftar yang muncul</small>
            </div>
            <div style="display:flex; gap:12px; margin-bottom:12px;">
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Jenis</label>
                    <select name="jenis" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                        <option value="Mutasi">Mutasi</option>
                        <option value="Pensiun">Pensiun</option>
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Tanggal Efektif</label>
                    <input type="date" name="tanggal_efektif" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Status Pengajuan</label>
                <select name="status_pengajuan" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                    <option value="Proses">Proses</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
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
            <h3 style="margin:0;">Edit Pengajuan</h3>
            <button onclick="closeModal('modalEdit')" style="background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Pegawai (NIP)</label>
                <input type="text" name="nip" id="edit_nip" readonly style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px; background:#f1f5f9; color:#64748b;">
                <small style="color:#94a3b8; font-size:11px;">*NIP tidak dapat diubah</small>
            </div>
            <div style="display:flex; gap:12px; margin-bottom:12px;">
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Jenis</label>
                    <select name="jenis" id="edit_jenis" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                        <option value="Mutasi">Mutasi</option>
                        <option value="Pensiun">Pensiun</option>
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="display:block; font-size:13px; margin-bottom:4px;">Tanggal Efektif</label>
                    <input type="date" name="tanggal_efektif" id="edit_tanggal" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                </div>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; margin-bottom:4px;">Status Pengajuan</label>
                <select name="status_pengajuan" id="edit_status" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                    <option value="Proses">Proses</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
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
    function openEditModal(id, nip, jenis, tanggal, status, keterangan) {
        document.getElementById('editForm').action = '/kepegawaian/mutasi/' + id;
        document.getElementById('edit_nip').value = nip;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('edit_tanggal').value = tanggal;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_keterangan').value = keterangan;
        openModal('modalEdit');
    }
</script>
@endsection
