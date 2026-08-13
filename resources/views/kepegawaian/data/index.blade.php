@extends('layouts.kepegawaian')

@section('title', 'Data Pegawai')

@section('content')
<div style="margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
        <div>
            <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">Data Pegawai</h2>
            <p style="margin:0; color:#64748b; font-size:14px;">Sumber data: Total Pegawai, PNS, PPPK, Non-ASN, komposisi jenis kelamin dan golongan.</p>
        </div>
        <button onclick="openModal('modalAdd')" style="background:#4f46e5; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Tambah Data Pegawai
        </button>
    </div>
</div>

<div class="table-container" style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
    <!-- Toolbar -->
    <div style="margin-bottom:20px;">
        <form action="{{ route('kepegawaian.data.index') }}" method="GET" style="display:flex; gap:12px;">
            <div style="position:relative; width:400px;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:16px; top:12px; color:#94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIP..." style="width:100%; padding:10px 16px 10px 42px; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:14px;">
            </div>
            <!-- Mockup shows empty inputs/filters beside search, let's keep it clean as we don't have those filter fields yet -->
        </form>
    </div>

    <!-- Table -->
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; text-align:left; white-space:nowrap;">
            <thead>
                <tr style="border-bottom:1px solid #e2e8f0;">
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">NIP / ID PEGAWAI</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">NAMA PEGAWAI</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">JENIS PEGAWAI</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">UNIT KERJA</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">JABATAN</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">GOLONGAN</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">STATUS</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">UPDATE TERAKHIR</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px; text-align:center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawais as $p)
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:16px 12px; font-size:13px; color:#64748b; font-family:monospace;">{{ $p->nip }}</td>
                    <td style="padding:16px 12px; font-size:14px; font-weight:600; color:#1e293b;">{{ $p->nama }}</td>
                    <td style="padding:16px 12px; font-size:13px;">
                        @if($p->jenis_pegawai == 'PNS')
                            <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">PNS</span>
                        @elseif($p->jenis_pegawai == 'PPPK')
                            <span style="background:#f3e8ff; border:1px solid #d8b4fe; color:#6b21a8; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">PPPK</span>
                        @else
                            <span style="background:#fff7ed; border:1px solid #fdba74; color:#c2410c; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">Non-ASN</span>
                        @endif
                    </td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $p->unit_kerja }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $p->jabatan }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $p->golongan ?? '-' }}</td>
                    <td style="padding:16px 12px; font-size:13px;">
                        @if($p->status_pegawai == 'Aktif')
                            <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">Aktif</span>
                        @elseif($p->status_pegawai == 'Mendekati Pensiun')
                            <span style="background:#fef9c3; border:1px solid #fde047; color:#854d0e; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">Mendekati Pensiun</span>
                        @else
                            <span style="background:#f1f5f9; border:1px solid #cbd5e1; color:#475569; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">{{ $p->status_pegawai }}</span>
                        @endif
                    </td>
                    <td style="padding:16px 12px; font-size:13px; color:#64748b;">
                        {{ $p->updated_at->format('d M Y') }}
                    </td>
                    <td style="padding:16px 12px; text-align:center;">
                        <a href="{{ route('kepegawaian.data.show', $p->id) }}" style="color:#3b82f6; margin-right:12px; font-size:14px;"><i class="fa-regular fa-eye"></i></a>
                        <!-- The mockup had an orange edit button next to the eye -->
                        <button onclick="openEditModal({{ $p->id }}, '{{ $p->nip }}', '{{ $p->nama }}', '{{ $p->jenis_pegawai }}', '{{ $p->jenis_kelamin }}', '{{ $p->jabatan }}', '{{ $p->golongan }}', '{{ $p->unit_kerja }}', '{{ $p->status_pegawai }}', '{{ $p->tanggal_bergabung }}')" style="background:none; border:none; color:#f59e0b; cursor:pointer; margin-right:12px; font-size:14px;"><i class="fa-regular fa-pen-to-square"></i></button>
                        <form action="{{ route('kepegawaian.data.destroy', $p->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data pegawai ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:14px;"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="padding:24px; text-align:center; color:#94a3b8;">Tidak ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalAdd" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:600px; border-radius:12px; padding:24px; max-height:90vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <h3 style="margin:0; font-size:18px; font-weight:700;">Tambah Data Pegawai</h3>
            <button onclick="closeModal('modalAdd')" style="background:none; border:none; font-size:20px; cursor:pointer; color:#64748b;">&times;</button>
        </div>
        <form action="{{ route('kepegawaian.data.store') }}" method="POST">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">NIP / ID Pegawai</label>
                    <input type="text" name="nip" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Nama Lengkap</label>
                    <input type="text" name="nama" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Jenis Pegawai</label>
                    <select name="jenis_pegawai" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                        <option value="PNS">PNS</option>
                        <option value="PPPK">PPPK</option>
                        <option value="Non-ASN">Non-ASN</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Unit Kerja</label>
                    <input type="text" name="unit_kerja" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Jabatan</label>
                    <input type="text" name="jabatan" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Golongan</label>
                    <input type="text" name="golongan" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Status</label>
                    <select name="status_pegawai" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                        <option value="Aktif">Aktif</option>
                        <option value="Mendekati Pensiun">Mendekati Pensiun</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Tugas Belajar">Tugas Belajar</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Tanggal Masuk (Bergabung)</label>
                    <input type="date" name="tanggal_bergabung" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
            </div>
            
            <div style="text-align:right; margin-top:24px;">
                <button type="button" onclick="closeModal('modalAdd')" style="background:#f1f5f9; color:#475569; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; margin-right:12px;">Batal</button>
                <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:600px; border-radius:12px; padding:24px; max-height:90vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <h3 style="margin:0; font-size:18px; font-weight:700;">Edit Data Pegawai</h3>
            <button onclick="closeModal('modalEdit')" style="background:none; border:none; font-size:20px; cursor:pointer; color:#64748b;">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">NIP / ID Pegawai</label>
                    <input type="text" name="nip" id="edit_nip" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Jenis Pegawai</label>
                    <select name="jenis_pegawai" id="edit_jenis_pegawai" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                        <option value="PNS">PNS</option>
                        <option value="PPPK">PPPK</option>
                        <option value="Non-ASN">Non-ASN</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="edit_jenis_kelamin" required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Unit Kerja</label>
                    <input type="text" name="unit_kerja" id="edit_unit_kerja" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Jabatan</label>
                    <input type="text" name="jabatan" id="edit_jabatan" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Golongan</label>
                    <input type="text" name="golongan" id="edit_golongan" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Status</label>
                    <select name="status_pegawai" id="edit_status" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                        <option value="Aktif">Aktif</option>
                        <option value="Mendekati Pensiun">Mendekati Pensiun</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Tugas Belajar">Tugas Belajar</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#334155; margin-bottom:6px;">Tanggal Masuk (Bergabung)</label>
                    <input type="date" name="tanggal_bergabung" id="edit_tanggal" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; outline:none;">
                </div>
            </div>
            
            <div style="text-align:right; margin-top:24px;">
                <button type="button" onclick="closeModal('modalEdit')" style="background:#f1f5f9; color:#475569; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; margin-right:12px;">Batal</button>
                <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">Simpan Perubahan</button>
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
    function openEditModal(id, nip, nama, jenis_pegawai, jenis_kelamin, jabatan, golongan, unit_kerja, status, tanggal) {
        document.getElementById('editForm').action = '/kepegawaian/data/' + id;
        document.getElementById('edit_nip').value = nip;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_jenis_pegawai').value = jenis_pegawai;
        document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
        document.getElementById('edit_jabatan').value = jabatan;
        document.getElementById('edit_golongan').value = golongan;
        document.getElementById('edit_unit_kerja').value = unit_kerja;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_tanggal').value = tanggal;
        openModal('modalEdit');
    }
</script>
@endsection
