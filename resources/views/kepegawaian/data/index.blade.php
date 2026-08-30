@extends('layouts.kepegawaian')

@section('title', 'Data Pegawai')

@section('content')
<div style="margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
        <div>
            <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">Data Pegawai</h2>
            <p style="margin:0; color:#64748b; font-size:14px;">Sumber data: Total Pegawai, PNS, PPPK, Non-ASN, komposisi jenis kelamin dan golongan.</p>
        </div>
        <a href="{{ route('kepegawaian.data.create') }}" style="background:#4f46e5; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; text-decoration:none; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Tambah Data Pegawai
        </a>
    </div>
</div>

<div class="table-container" style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
    <!-- Toolbar -->
    <div style="margin-bottom:20px;">
        <form action="{{ route('kepegawaian.data.index') }}" method="GET" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            <div style="position:relative; flex:1; min-width:250px; max-width:400px;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:16px; top:12px; color:#94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIP..." style="width:85%; padding:10px 16px 10px 42px; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:14px;">
            </div>
            <!-- Removed empty mockup filters to match actual functionality -->
            <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">Cari</button>
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
                        <a href="{{ route('kepegawaian.data.edit', $p->id) }}" style="color:#f59e0b; margin-right:12px; font-size:14px;"><i class="fa-regular fa-pen-to-square"></i></a>
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
@endsection
