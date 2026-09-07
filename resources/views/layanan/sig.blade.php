@extends('layouts.app')

@section('title', 'Pusat Data SIG - Command Center Kota Magelang')

@section('content')

<div class="wrap" style="padding-bottom: 80px;">
    <!-- Breadcrumb -->
    <div class="breadcrumb" style="margin-top: 24px;">
        <a href="{{ route('home') }}">Beranda</a> &rsaquo; <span>Data SIG</span>
    </div>

    <!-- Hero Card -->
    <div class="dashboard-hero bg-green-light" style="position:relative; overflow:hidden; padding: 32px 40px; border-radius: 16px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); margin-bottom: 24px;">
        <h1 class="dashboard-hero-title" style="font-size:28px; font-weight:700; color:#065f46; margin:0 0 8px;">Pusat Data SIG</h1>
        <p class="dashboard-hero-desc" style="color:#047857; font-size:14px; max-width:480px; margin:0;">Informasi publik dan statistik spasial Kota Magelang.</p>
        <div style="position:absolute; right:-30px; top:-30px; width:180px; height:180px; background:rgba(16, 185, 129, 0.12); border-radius:50%; pointer-events:none;"></div>
    </div>

    <!-- Filter Bar -->
    <div style="display:flex; gap:12px; margin-bottom:24px; align-items:center; flex-wrap:wrap;">
        <select style="border:1px solid #e2e8f0; border-radius:8px; padding:10px 16px; font-size:13px; color:#64748b; background:#fff; flex:1; min-width:130px;">
            <option value="">Semua Kecamatan</option>
            <option value="Magelang Utara">Magelang Utara</option>
            <option value="Magelang Tengah">Magelang Tengah</option>
            <option value="Magelang Selatan">Magelang Selatan</option>
        </select>
        <select style="border:1px solid #e2e8f0; border-radius:8px; padding:10px 16px; font-size:13px; color:#64748b; background:#fff; flex:1; min-width:130px;">
            <option value="">Semua Kategori</option>
            <option value="Sanitasi">Sanitasi</option>
            <option value="Fasilitas">Fasilitas</option>
            <option value="Pangan">Pangan</option>
        </select>
        <select style="border:1px solid #e2e8f0; border-radius:8px; padding:10px 16px; font-size:13px; color:#64748b; background:#fff; flex:1; min-width:130px;">
            <option value="">Tahun 2026</option>
            <option value="2025">Tahun 2025</option>
            <option value="2024">Tahun 2024</option>
        </select>
        <select style="border:1px solid #e2e8f0; border-radius:8px; padding:10px 16px; font-size:13px; color:#64748b; background:#fff; flex:1; min-width:130px;">
            <option value="">Status Layer</option>
            <option value="Aktif">Aktif</option>
        </select>
        <div style="position:relative; flex:2; min-width:200px;">
            <input type="text" placeholder="Search Indikator..." style="width:100%; border:1px solid #e2e8f0; border-radius:8px; padding:10px 16px 10px 38px; font-size:13px; color:#334155; background:#fff;">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px;"></i>
        </div>
        <button style="background:#2563eb; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:600; font-size:13px; cursor:pointer; transition:background .2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">Terapkan Filter</button>
    </div>

    <!-- Middle Section: Layer Publik & Peta Utama -->
    <div style="display:grid; grid-template-columns:300px 1fr; gap:24px; margin-bottom:24px; align-items:stretch;">
        <!-- Left: Layer Publik List -->
        <div style="background:#fff; border:1px solid #f1f5f9; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
            <h3 style="font-size:16px; font-weight:700; color:#1e293b; margin:0 0 16px 0;">Layer Publik</h3>
            <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach ($layerPublik as $index => $layer)
                    <button type="button" 
                            class="sig-layer-btn {{ $index === 0 ? 'active' : '' }}" 
                            onclick="selectSigLayer('{{ $layer }}', this)"
                            style="width:100%; text-align:left; padding:12px 16px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; transition:all .2s; border:1px solid {{ $index === 0 ? '#2563eb' : '#e2e8f0' }}; background:{{ $index === 0 ? '#2563eb' : '#f8fafc' }}; color:{{ $index === 0 ? '#ffffff' : '#334155' }};">
                        {{ $layer }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Right: Map Box -->
        <div style="background:#fff; border:1px solid #f1f5f9; border-radius:16px; padding:20px; box-shadow:0 1px 3px rgba(0,0,0,.05); display:flex; flex-direction:column;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h3 id="mapTitle" style="font-size:16px; font-weight:700; color:#1e293b; margin:0;">Peta Utama: {{ $layerPublik[0] ?? 'Mata Air' }}</h3>
                <span style="background:#ecfdf5; color:#16a34a; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; border:1px solid #bbf7d0;">Layer Aktif</span>
            </div>
            <div id="sigMap" style="width:100%; height:400px; border-radius:12px; overflow:hidden; z-index:1;"></div>
        </div>
    </div>

    <!-- 6 Stat Cards Grid -->
    <div style="display:grid; grid-template-columns:repeat(6, 1fr); gap:16px; margin-bottom:24px;">
        @foreach ($statsSIG as $stat)
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:18px 16px; display:flex; flex-direction:column; justify-content:space-between; gap:8px;">
                <div>
                    <div style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; line-clamp:1; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $stat['label'] }}">{{ $stat['label'] }}</div>
                    <div style="font-size:24px; font-weight:700; color:#0f172a;">{{ $stat['value'] }}</div>
                </div>
                <div>
                    <a href="javascript:void(0)" onclick="openSigDetailModal('{{ $stat['label'] }}', '{{ $stat['value'] }}')" 
                       style="display:inline-block; border:1px solid #2563eb; color:#2563eb; border-radius:20px; padding:4px 14px; font-size:11px; font-weight:600; text-decoration:none; transition:all .2s;" 
                       onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='transparent'">
                        Lihat Data
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Bottom Section: Tabel Data & Informasi Terbaru -->
    <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">
        <!-- Left: Tabel Data SIG Publik -->
        <div style="background:#fff; border:1px solid #f1f5f9; border-radius:16px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
            <h3 style="font-size:16px; font-weight:700; color:#1e293b; margin:0 0 20px 0;">Tabel Data SIG Publik</h3>
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; text-align:left;">
                    <thead>
                        <tr style="border-bottom:1px solid #e2e8f0; background:#f8fafc;">
                            <th style="padding:12px 14px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">NAMA DATA</th>
                            <th style="padding:12px 14px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">KATEGORI</th>
                            <th style="padding:12px 14px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">WILAYAH</th>
                            <th style="padding:12px 14px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">NILAI / JUMLAH</th>
                            <th style="padding:12px 14px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">UPDATE TERAKHIR</th>
                            <th style="padding:12px 14px; font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tabelSIG as $row)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:14px; font-size:13px; font-weight:600; color:#1e293b;">{{ $row['nama_data'] }}</td>
                                <td style="padding:14px; font-size:12px; color:#475569;">{{ $row['kategori'] }}</td>
                                <td style="padding:14px; font-size:12px; color:#475569;">{{ $row['wilayah'] }}</td>
                                <td style="padding:14px; font-size:13px; font-weight:700; color:#0f172a;">{{ $row['nilai_jumlah'] }}</td>
                                <td style="padding:14px; font-size:12px; color:#64748b;">{{ $row['update_terakhir'] }}</td>
                                <td style="padding:14px;">
                                    <a href="javascript:void(0)" onclick="openSigDetailModal('{{ $row['nama_data'] }}', '{{ $row['kategori'] }} - {{ $row['wilayah'] }}')" 
                                       style="display:inline-block; border:1px solid #2563eb; color:#2563eb; border-radius:20px; padding:4px 14px; font-size:11px; font-weight:600; text-decoration:none; transition:all .2s;"
                                       onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='transparent'">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Informasi Terbaru -->
        <div style="background:#fff; border:1px solid #f1f5f9; border-radius:16px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.05);">
            <h3 style="font-size:16px; font-weight:700; color:#1e293b; margin:0 0 20px 0;">Informasi Terbaru</h3>
            <div style="display:flex; flex-direction:column; gap:16px;">
                @foreach ($infoTerbaruSIG as $info)
                    <div style="border:1px solid #e2e8f0; border-radius:12px; padding:16px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px; margin-bottom:6px;">
                            <div style="font-size:14px; font-weight:700; color:#1e293b; line-height:1.3;">{{ $info['judul'] }}</div>
                            <span style="background:{{ $info['badge'] === 'warning' ? '#fefce8' : '#ecfdf5' }}; color:{{ $info['badge'] === 'warning' ? '#ca8a04' : '#16a34a' }}; border:1px solid {{ $info['badge'] === 'warning' ? '#fef08a' : '#bbf7d0' }}; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap;">
                                {{ $info['status'] }}
                            </span>
                        </div>
                        <div style="font-size:12px; color:#64748b; margin-bottom:12px;">{{ $info['kategori'] }} &middot; {{ $info['tanggal'] }}</div>
                        <div>
                            @php
                                $filePath = isset($info['file_path']) && file_exists(storage_path('app/public/' . $info['file_path'])) 
                                    ? asset('storage/' . $info['file_path']) 
                                    : asset('sample-document.pdf');
                            @endphp
                            <a href="{{ $filePath }}" target="_blank" 
                               style="display:inline-block; border:1px solid #2563eb; color:#2563eb; border-radius:20px; padding:4px 14px; font-size:11px; font-weight:600; text-decoration:none; transition:all .2s;"
                               onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='transparent'">
                                Lihat PDF
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Dummy Interactive -->
<div id="sigDetailModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:28px; width:90%; max-width:460px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
        <h3 id="sigModalTitle" style="font-size:18px; font-weight:700; color:#1e293b; margin:0 0 10px 0;">Detail Data SIG</h3>
        <p id="sigModalBody" style="font-size:14px; color:#475569; margin:0 0 20px 0; line-height:1.5;">Memuat informasi data spasial...</p>
        <div style="display:flex; justify-content:flex-end;">
            <button onclick="closeSigDetailModal()" style="background:#2563eb; color:#fff; border:none; padding:8px 20px; border-radius:8px; font-weight:600; cursor:pointer;">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('extraStyles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
@media (max-width: 1024px) {
    .wrap > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

@section('extraScripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map = null;
let currentMarker = null;

document.addEventListener('DOMContentLoaded', function() {
    initSigMap();
});

function initSigMap() {
    const mapElement = document.getElementById('sigMap');
    if (!mapElement) return;

    // Center on Kota Magelang
    map = L.map('sigMap').setView([-7.4797, 110.2177], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    currentMarker = L.marker([-7.4797, 110.2177]).addTo(map)
        .bindPopup('<b>Mata Air Kota Magelang</b><br>Titik pemantauan utama.')
        .openPopup();
}

function selectSigLayer(layerName, btnElement) {
    // Update active button state
    document.querySelectorAll('.sig-layer-btn').forEach(btn => {
        btn.style.background = '#f8fafc';
        btn.style.color = '#334155';
        btn.style.borderColor = '#e2e8f0';
        btn.classList.remove('active');
    });

    if (btnElement) {
        btnElement.style.background = '#2563eb';
        btnElement.style.color = '#ffffff';
        btnElement.style.borderColor = '#2563eb';
        btnElement.classList.add('active');
    }

    // Update map header
    const titleEl = document.getElementById('mapTitle');
    if (titleEl) {
        titleEl.textContent = 'Peta Utama: ' + layerName;
    }

    // Move map marker slightly to demonstrate interactivity
    if (map && currentMarker) {
        const offsets = {
            'Mata Air': [-7.4797, 110.2177],
            'Kemiskinan': [-7.4850, 110.2100],
            'Bahaya Banjir': [-7.4710, 110.2250],
            'Distribusi Pangan': [-7.4650, 110.2150],
            'Bahaya Genangan': [-7.4780, 110.2300],
            'Distribusi Sanitasi': [-7.4815, 110.2078],
            'Kerentanan Pangan': [-7.4900, 110.2180],
            'Volume to Capacity Ratio': [-7.4750, 110.2200],
            'Batas Wilayah Administrasi': [-7.4797, 110.2177]
        };

        const coords = offsets[layerName] || [-7.4797, 110.2177];
        map.flyTo(coords, 14);
        currentMarker.setLatLng(coords);
        currentMarker.bindPopup('<b>Layer: ' + layerName + '</b><br>Kota Magelang').openPopup();
    }
}

function openSigDetailModal(title, detail) {
    document.getElementById('sigModalTitle').textContent = title;
    document.getElementById('sigModalBody').textContent = 'Informasi statistik spasial untuk ' + title + ' (' + detail + '). Data ini diperbarui secara berkala oleh Divisi SIG Command Center Kota Magelang.';
    document.getElementById('sigDetailModal').style.display = 'flex';
}

function closeSigDetailModal() {
    document.getElementById('sigDetailModal').style.display = 'none';
}
</script>
@endsection
