@extends('layouts.kepegawaian')

@section('title', 'Informasi Terbaru')

@section('content')
<div style="margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
        <div>
            <h2 style="margin:0 0 8px 0; font-size:24px; color:#1e293b; font-weight:700;">Informasi Terbaru</h2>
            <p style="margin:0; color:#64748b; font-size:14px;">Publikasi dokumen kepegawaian — tidak mempengaruhi angka statistik dashboard.</p>
        </div>
        <a href="{{ route('kepegawaian.informasi.create') }}" style="background:#4f46e5; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Tambah Informasi
        </a>
    </div>
</div>

<div class="table-container" style="background:#fff; border-radius:12px; border:1px solid #e2e8f0; padding:24px;">
    <!-- Toolbar -->
    <div style="margin-bottom:20px;">
        <form action="{{ route('kepegawaian.informasi.index') }}" method="GET" style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
            <div style="position:relative; flex:1; min-width:250px; max-width:500px;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:16px; top:12px; color:#94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Informasi..." style="width:90%; padding:10px 16px 10px 42px; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:14px;">
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
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">JUDUL PUBLIKASI</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">KATEGORI</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">FILE PDF</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">TANGGAL UPDATE</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">STATUS</th>
                    <th style="padding:16px 12px; color:#64748b; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px; text-align:center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($informasis as $info)
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:16px 12px; font-size:14px; font-weight:600; color:#1e293b;">{{ $info->judul }}</td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $info->kategori }}</td>
                    <td style="padding:16px 12px; font-size:13px;">
                        <a href="#" style="color:#3b82f6; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                            <i class="fa-regular fa-file-pdf"></i> {{ $info->dokumen ?? 'dokumen-default.pdf' }}
                        </a>
                    </td>
                    <td style="padding:16px 12px; font-size:13px; color:#475569;">{{ $info->updated_at->format('d M Y') }}</td>
                    <td style="padding:16px 12px; font-size:13px;">
                        @if($info->status_publikasi == 'Rilis')
                            <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">Rilis</span>
                        @else
                            <span style="background:#fef3c7; border:1px solid #fde047; color:#854d0e; padding:4px 12px; border-radius:999px; font-size:11px; font-weight:600;">{{ $info->status_publikasi }}</span>
                        @endif
                    </td>
                    <td style="padding:16px 12px; text-align:center;">
                        <a href="{{ route('kepegawaian.informasi.show', $info->id) }}" style="color:#3b82f6; margin-right:12px; font-size:14px;"><i class="fa-regular fa-eye"></i></a>
                        <a href="{{ route('kepegawaian.informasi.edit', $info->id) }}" style="color:#f59e0b; margin-right:12px; font-size:14px;"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form action="{{ route('kepegawaian.informasi.destroy', $info->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus informasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:14px;"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:24px; text-align:center; color:#94a3b8;">Tidak ada data informasi terbaru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
