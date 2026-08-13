@extends('layouts.kepegawaian')

@section('title', 'Mutasi & Pensiun')

@section('content')
<div style="margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">Mutasi & Pensiun</h2>
            <p style="margin:0; color:#64748b; font-size:14px;">Sumber data: mutasi tahun ini dan pegawai mendekati pensiun pada dashboard.</p>
        </div>
        <a href="{{ route('kepegawaian.mutasi.create') }}" style="background:#4f46e5; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Tambah Data Mutasi / Pensiun
        </a>
    </div>

    <!-- Tabs Mockup -->
    <div style="display:flex; gap:12px; margin-bottom:24px;">
        <div style="background:#4f46e5; color:#fff; padding:8px 20px; border-radius:999px; font-size:14px; font-weight:600; cursor:pointer;">Data Mutasi</div>
        <div style="background:#fff; border:1px solid #e2e8f0; color:#64748b; padding:8px 20px; border-radius:999px; font-size:14px; font-weight:600; cursor:pointer;">Data Pensiun</div>
    </div>
</div>

<div class="table-container" style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
    <!-- Toolbar -->
    <div style="margin-bottom:20px;">
        <form action="{{ route('kepegawaian.mutasi.index') }}" method="GET" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            <div style="position:relative; flex:1 1 250px; min-width:200px; max-width:480px;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, atau unit..." style="width:100%; padding:10px 16px 10px 40px; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:14px; box-sizing:border-box;">
            </div>
            <!-- Empty Filter Mockups -->
            <select style="padding:10px 16px; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:14px; color:#64748b; width:150px; background:#fff;">
                <option value="">Semua Unit</option>
            </select>
            <select style="padding:10px 16px; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:14px; color:#64748b; width:150px; background:#fff;">
                <option value="">Tahun Ini</option>
            </select>
            <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">Terapkan Filter</button>
        </form>
    </div>

    <!-- Table -->
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; text-align:left; white-space:nowrap;">
            <thead>
                <tr style="border-bottom:1px solid #e2e8f0;">
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">NAMA PEGAWAI</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">NIP / ID</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">UNIT ASAL</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">UNIT TUJUAN</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">JENIS PERUBAHAN</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">TANGGAL</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">STATUS PROSES</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px; text-align:center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mutasis as $m)
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:16px 12px; font-size:14px; font-weight:600; color:#1e293b;">{{ $m->nama_pegawai }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#64748b; font-family:monospace;">{{ $m->nip }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $m->unit_asal ?? 'Unit Lama' }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $m->unit_tujuan ?? 'Unit Baru' }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $m->jenis }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ \Carbon\Carbon::parse($m->tanggal_efektif)->format('d M Y') }}</td>
                    <td style="padding:16px 12px; font-size:13px;">
                        @if($m->status_pengajuan == 'Selesai')
                            <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">Selesai</span>
                        @elseif($m->status_pengajuan == 'Berjalan')
                            <span style="background:#fef3c7; border:1px solid #fde047; color:#854d0e; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">Berjalan</span>
                        @else
                            <span style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">{{ $m->status_pengajuan }}</span>
                        @endif
                    </td>
                    <td style="padding:16px 12px; text-align:center;">
                        <a href="{{ route('kepegawaian.mutasi.show', $m->id) }}" style="color:#3b82f6; margin-right:12px; font-size:14px;"><i class="fa-regular fa-eye"></i></a>
                        <a href="{{ route('kepegawaian.mutasi.edit', $m->id) }}" style="color:#f59e0b; margin-right:12px; font-size:14px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form action="{{ route('kepegawaian.mutasi.destroy', $m->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:14px;"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:24px; text-align:center; color:#94a3b8;">Tidak ada data mutasi/pensiun.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
