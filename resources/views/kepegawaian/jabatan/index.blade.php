@extends('layouts.kepegawaian')

@section('title', 'Jabatan & Unit Kerja')

@section('content')
<div style="margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">Jabatan & Unit Kerja</h2>
            <p style="margin:0; color:#64748b; font-size:14px;">Sumber data: struktur unit kerja, grafik pegawai per unit, dan filter unit pada dashboard.</p>
        </div>
        <a href="{{ route('kepegawaian.jabatan.create') }}" style="background:#4f46e5; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Tambah Unit / Jabatan
        </a>
    </div>

    <!-- 3 Metrics Cards -->
    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; margin-bottom:24px;">
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; background:#eff6ff; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#3b82f6; font-size:20px;">
                <i class="fa-solid fa-building"></i>
            </div>
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">TOTAL UNIT KERJA</p>
                <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700;">{{ $totalUnit }} Unit</h3>
            </div>
        </div>
        
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; background:#f0fdf4; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#22c55e; font-size:20px;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">TOTAL PEGAWAI</p>
                <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700;">{{ $totalPegawai }} Pegawai</h3>
            </div>
        </div>

        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; background:#eff6ff; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#3b82f6; font-size:20px;">
                <i class="fa-solid fa-building-circle-check"></i>
            </div>
            <div>
                <p style="margin:0 0 4px 0; font-size:12px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">UNIT AKTIF</p>
                <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700;">{{ $unitAktif }} Unit</h3>
            </div>
        </div>
    </div>
</div>

<div class="table-container" style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
    <!-- Toolbar -->
    <div style="margin-bottom:20px;">
        <form action="{{ route('kepegawaian.jabatan.index') }}" method="GET" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            <div style="position:relative; flex:1; min-width:250px; max-width:400px;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:16px; top:12px; color:#94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari unit atau kode..." style="width:80%; padding:10px 16px 10px 42px; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:14px;">
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
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">NAMA UNIT KERJA</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">KODE UNIT</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">JUMLAH PEGAWAI</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">JABATAN UTAMA</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">STATUS UNIT</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px; text-align:center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jabatans as $j)
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:16px 12px; font-size:14px; font-weight:600; color:#1e293b;">{{ $j->nama_jabatan }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#64748b; font-family:monospace;">{{ $j->kode_unit }}</td>
                    <td style="padding:16px 12px; font-size:13px; font-weight:600; color:#3b82f6;">{{ $j->jumlah_pegawai }} Pegawai</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $j->jabatan_utama ?? '-' }}</td>
                    <td style="padding:16px 12px; font-size:13px;">
                        @if($j->status == 'Aktif')
                            <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">Aktif</span>
                        @else
                            <span style="background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">{{ $j->status }}</span>
                        @endif
                    </td>
                    <td style="padding:16px 12px; text-align:center;">
                        <a href="{{ route('kepegawaian.jabatan.show', $j->id) }}" style="color:#3b82f6; margin-right:12px; font-size:14px;"><i class="fa-regular fa-eye"></i></a>
                        <a href="{{ route('kepegawaian.jabatan.edit', $j->id) }}" style="color:#f59e0b; margin-right:12px; font-size:14px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form action="{{ route('kepegawaian.jabatan.destroy', $j->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus unit kerja ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:14px;"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:24px; text-align:center; color:#94a3b8;">Tidak ada data unit kerja.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
