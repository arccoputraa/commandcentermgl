@extends('layouts.kepegawaian')

@section('title', 'Detail Unit Kerja')

@section('content')
<div style="margin-bottom:24px;">
    <!-- Breadcrumb -->
    <div style="font-size:13px; color:#64748b; margin-bottom:12px;">
        Dashboard &nbsp;/&nbsp; Jabatan & Unit Kerja &nbsp;/&nbsp; <strong style="color:#0f172a;">Detail Unit</strong>
    </div>

    <!-- Header Actions -->
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2 style="margin:0; font-size:24px; color:#1e293b; font-weight:700;">{{ $jabatan->nama_jabatan }}</h2>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('kepegawaian.jabatan.index') }}" style="background:#fff; border:1px solid #e2e8f0; color:#334155; padding:8px 16px; border-radius:8px; font-weight:600; text-decoration:none;">Kembali</a>
            <a href="{{ route('kepegawaian.jabatan.edit', $jabatan->id) }}" style="background:#4f46e5; color:#fff; border:none; padding:8px 16px; border-radius:8px; font-weight:600; text-decoration:none; display:flex; align-items:center; gap:8px;">
                <i class="fa-regular fa-pen-to-square"></i> Edit Unit Kerja
            </a>
        </div>
    </div>
</div>

<!-- Metrics Grid -->
<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px;">
        <p style="margin:0 0 4px 0; font-size:11px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">KODE UNIT</p>
        <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700; font-family:monospace;">{{ $jabatan->kode_unit }}</h3>
    </div>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px;">
        <p style="margin:0 0 4px 0; font-size:11px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">TOTAL PEGAWAI</p>
        <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700;">{{ $pegawais->count() }}</h3>
    </div>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px;">
        <p style="margin:0 0 4px 0; font-size:11px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">PNS</p>
        <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700;">{{ $pns }}</h3>
    </div>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px;">
        <p style="margin:0 0 4px 0; font-size:11px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">PPPK</p>
        <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700;">{{ $pppk }}</h3>
    </div>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px;">
        <p style="margin:0 0 4px 0; font-size:11px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">NON-ASN</p>
        <h3 style="margin:0; font-size:20px; color:#0f172a; font-weight:700;">{{ $non_asn }}</h3>
    </div>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px;">
        <p style="margin:0 0 4px 0; font-size:11px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">STATUS</p>
        <h3 style="margin:0; font-size:18px; color:#0f172a; font-weight:700;">
            @if($jabatan->status == 'Aktif')
                <span style="color:#166534;">Aktif</span>
            @else
                <span style="color:#991b1b;">{{ $jabatan->status }}</span>
            @endif
        </h3>
    </div>
</div>

<!-- Lists -->
<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
    <!-- Daftar Jabatan -->
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:24px;">
        <h3 style="margin:0 0 16px 0; font-size:16px; color:#1e293b; font-weight:700;">Daftar Jabatan dalam Unit</h3>
        @php
            // Extract unique jabatans from pegawais
            $jabatanList = $pegawais->pluck('jabatan')->filter()->unique();
            $index = 1;
        @endphp
        
        <div style="display:flex; flex-direction:column; gap:12px;">
            <!-- Jabatan Utama from Unit Kerja config -->
            @if($jabatan->jabatan_utama)
                <div style="background:#f8fafc; border-radius:8px; padding:12px 16px; display:flex; align-items:center; gap:16px;">
                    <div style="width:28px; height:28px; background:#e0e7ff; color:#4f46e5; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700;">1</div>
                    <div style="font-size:14px; font-weight:500; color:#1e293b;">{{ $jabatan->jabatan_utama }} (Jabatan Utama)</div>
                </div>
                @php $index++; @endphp
            @endif
            
            @foreach($jabatanList as $jabName)
                @if($jabName != $jabatan->jabatan_utama)
                <div style="background:#f8fafc; border-radius:8px; padding:12px 16px; display:flex; align-items:center; gap:16px;">
                    <div style="width:28px; height:28px; background:#eff6ff; color:#3b82f6; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700;">{{ $index }}</div>
                    <div style="font-size:14px; color:#475569;">{{ $jabName }}</div>
                </div>
                @php $index++; @endphp
                @endif
            @endforeach
            
            @if($jabatanList->isEmpty() && !$jabatan->jabatan_utama)
                <p style="color:#94a3b8; font-size:14px; font-style:italic;">Belum ada jabatan.</p>
            @endif
        </div>
    </div>

    <!-- Daftar Pegawai -->
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:24px;">
        <h3 style="margin:0 0 16px 0; font-size:16px; color:#1e293b; font-weight:700;">Daftar Pegawai dalam Unit</h3>
        <div style="display:flex; flex-direction:column; gap:12px;">
            @forelse($pegawais as $p)
                <div style="border:1px solid #f1f5f9; border-radius:8px; padding:12px 16px; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <h4 style="margin:0 0 4px 0; font-size:14px; color:#0f172a; font-weight:600;">{{ $p->nama }}</h4>
                        <p style="margin:0; font-size:12px; color:#64748b;">{{ $p->jabatan ?? '-' }} &bull; Gol. {{ $p->golongan ?? '-' }} &bull; {{ $p->jenis_pegawai }}</p>
                    </div>
                    <div>
                        @if($p->status_pegawai == 'Aktif')
                            <span style="background:#dcfce7; border:1px solid #86efac; color:#166534; padding:2px 12px; border-radius:999px; font-size:11px; font-weight:600;">Aktif</span>
                        @else
                            <span style="background:#f1f5f9; border:1px solid #cbd5e1; color:#475569; padding:2px 12px; border-radius:999px; font-size:11px; font-weight:600;">{{ $p->status_pegawai }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <p style="color:#94a3b8; font-size:14px; font-style:italic;">Belum ada pegawai di unit ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
