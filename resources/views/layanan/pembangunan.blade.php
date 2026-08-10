<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembangunan - Command Center Kota Magelang</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>body{font-family:'Plus Jakarta Sans',sans-serif;} #map2{height:100%;width:100%;border-radius:.75rem;}</style>
</head>
<body class="bg-slate-50 text-slate-800">

<header class="bg-white border-b border-slate-200 sticky top-0 z-30">
  <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
    <a href="home.html" class="flex items-center gap-2">
      <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white text-sm">🏛️</span>
      <span class="font-semibold text-slate-800">Command Center Kota Magelang</span>
    </a>
    <nav class="flex items-center gap-6 text-sm">
      <a href="home.html" class="text-slate-600 hover:text-blue-600">Beranda</a>
      <a href="tentang.html" class="text-slate-600 hover:text-blue-600">Tentang</a>
      <a href="login.html" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg">Login Sistem</a>
    </nav>
  </div>
</header>

<div class="max-w-7xl mx-auto px-6 pt-4 text-xs text-slate-500">
  <a href="home.html" class="hover:text-blue-600">Beranda</a> <span class="mx-1">›</span> <span class="text-slate-700">Data Pembangunan</span>
</div>

<main class="max-w-7xl mx-auto px-6 py-6 space-y-6">

  <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border border-orange-100 p-8">
    <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-orange-200/40 blur-2xl"></div>
    <div class="relative">
      <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Pusat Data Pembangunan</h1>
      <p class="text-slate-600 mt-1 max-w-xl">Informasi publik dan statistik sektoral pembangunan Kota Magelang.</p>
    </div>
  </section>

  <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Total Proyek</p><p class="text-2xl font-bold mt-1">32 Proyek</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Proyek Berjalan</p><p class="text-2xl font-bold mt-1">18 Proyek</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Proyek Selesai</p><p class="text-2xl font-bold mt-1">9 Proyek</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Proyek Tertunda</p><p class="text-2xl font-bold mt-1">3 Proyek</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Total Anggaran</p><p class="text-2xl font-bold mt-1">Rp28,5 M</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Total Realisasi</p><p class="text-2xl font-bold mt-1">Rp19,8 M</p></div>
  </section>
  <section class="grid grid-cols-2 md:grid-cols-2 gap-4">
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Rata-rata Progres Fisik</p><p class="text-2xl font-bold mt-1">74%</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Update Terakhir</p><p class="text-lg font-bold mt-1">03 Juli 2026</p></div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-wrap gap-3 items-center">
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Kecamatan</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Kategori</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Status</option></select>
    <div class="flex-1 min-w-[160px] relative">
      <span class="absolute left-3 top-2.5 text-slate-400 text-sm">🔍</span>
      <input placeholder="Search proyek" class="w-full border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm">
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Terapkan Filter</button>
  </section>

  <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Progres Proyek per Bulan</h3>
      <div id="chartProgres"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Status Proyek</h3>
      <div id="chartStatusProyek"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Realisasi Anggaran Pembangunan</h3>
      <div id="chartRealisasi"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Proyek Berdasarkan Kategori</h3>
      <div id="chartKategori"></div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-sm font-semibold text-slate-700 mb-3">Peta / Visual Lokasi Pembangunan</h3>
      <div id="map2" class="h-64"></div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi Terbaru</h3>
      <div class="space-y-3">
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Laporan Progres Pembangunan Semester I 2026</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Laporan Progres Pembangunan · 03 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Rekap Proyek Infrastruktur 2026</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Rekap Proyek · 02 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Publikasi Pembangunan Fasilitas Umum</p><span class="text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Draft</span></div>
          <p class="text-xs text-slate-400 mt-1">Publikasi Infrastruktur · 01 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Laporan Realisasi Pembangunan Triwulan II</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Laporan Realisasi Pembangunan · 02 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="p-4 border-b border-slate-100"><h3 class="text-sm font-semibold text-slate-700">Tabel Ringkas Proyek Pembangunan</h3></div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
          <tr>
            <th class="text-left px-4 py-3 font-medium">Kode Proyek</th>
            <th class="text-left px-4 py-3 font-medium">Nama Proyek</th>
            <th class="text-left px-4 py-3 font-medium">Kategori</th>
            <th class="text-left px-4 py-3 font-medium">Kecamatan</th>
            <th class="text-left px-4 py-3 font-medium">Kelurahan</th>
            <th class="text-left px-4 py-3 font-medium">Anggaran</th>
            <th class="text-left px-4 py-3 font-medium">Progres</th>
            <th class="text-left px-4 py-3 font-medium">Status</th>
            <th class="text-left px-4 py-3 font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr><td class="px-4 py-3">PRJ-2026-001</td><td class="px-4 py-3">Peningkatan Jalan Tidar Selatan</td><td class="px-4 py-3">Jalan & Jembatan</td><td class="px-4 py-3">Magelang Selatan</td><td class="px-4 py-3">Tidar Selatan</td><td class="px-4 py-3">Rp1,8 M</td><td class="px-4 py-3">72%</td><td class="px-4 py-3"><span class="text-amber-600 font-medium">Berjalan</span></td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">PRJ-2026-002</td><td class="px-4 py-3">Rehabilitasi Drainase Panjang</td><td class="px-4 py-3">Drainase</td><td class="px-4 py-3">Magelang Tengah</td><td class="px-4 py-3">Panjang</td><td class="px-4 py-3">Rp850 Juta</td><td class="px-4 py-3">58%</td><td class="px-4 py-3"><span class="text-amber-600 font-medium">Berjalan</span></td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">PRJ-2026-003</td><td class="px-4 py-3">Renovasi Gedung Pelayanan Publik</td><td class="px-4 py-3">Gedung Pemerintahan</td><td class="px-4 py-3">Magelang Tengah</td><td class="px-4 py-3">Kemirirejo</td><td class="px-4 py-3">Rp2,4 M</td><td class="px-4 py-3">34%</td><td class="px-4 py-3"><span class="text-red-600 font-medium">Perlu Perhatian</span></td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">PRJ-2026-004</td><td class="px-4 py-3">Pembangunan Taman Kelurahan</td><td class="px-4 py-3">Ruang Terbuka Hijau</td><td class="px-4 py-3">Magelang Utara</td><td class="px-4 py-3">Kedungsari</td><td class="px-4 py-3">Rp620 Juta</td><td class="px-4 py-3">100%</td><td class="px-4 py-3"><span class="text-green-600 font-medium">Selesai</span></td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">PRJ-2026-005</td><td class="px-4 py-3">Perbaikan Fasilitas Pasar Rejowinangun</td><td class="px-4 py-3">Fasilitas Umum</td><td class="px-4 py-3">Magelang Selatan</td><td class="px-4 py-3">Rejowinangun</td><td class="px-4 py-3">Rp1,2 M</td><td class="px-4 py-3">25%</td><td class="px-4 py-3"><span class="text-red-500 font-medium">Tertunda</span></td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
        </tbody>
      </table>
    </div>
  </section>

  <section>
    <h3 class="text-sm font-semibold text-slate-700 mb-3">Dokumentasi Publik Proyek</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="h-32 bg-slate-100 flex items-center justify-center text-slate-300 text-3xl">📷</div>
        <div class="p-4">
          <p class="text-sm font-medium">Foto Progres Minggu Ke-4</p>
          <p class="text-xs text-slate-400 mt-1">Peningkatan Jalan Tidar Selatan · 28 Jun 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Dokumentasi</a>
        </div>
      </div>
      <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="h-32 bg-slate-100 flex items-center justify-center text-slate-300 text-3xl">📷</div>
        <div class="p-4">
          <p class="text-sm font-medium">Dokumentasi Drainase Sisi Utara</p>
          <p class="text-xs text-slate-400 mt-1">Rehabilitasi Drainase Panjang · Pemasangan saluran beton</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Dokumentasi</a>
        </div>
      </div>
      <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="h-32 bg-slate-100 flex items-center justify-center text-slate-300 text-3xl">📷</div>
        <div class="p-4">
          <p class="text-sm font-medium">Laporan Progres Juni</p>
          <p class="text-xs text-slate-400 mt-1">Renovasi Gedung Pelayanan Publik · Laporan progres fisik dan anggaran</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Dokumentasi</a>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="bg-slate-900 text-slate-400 text-center text-xs py-6 mt-10">
  Command Center Kota Magelang<br>© 2026 Pemerintah Kota Magelang. Hak Cipta Dilindungi.
</footer>

<script>
const barOpts = (categories, data, color) => ({
  chart:{type:'bar', height:220, toolbar:{show:false}},
  plotOptions:{bar:{horizontal:true, borderRadius:4, barHeight:'55%'}},
  dataLabels:{enabled:true, style:{colors:['#334155']}, offsetX:20},
  series:[{name:'Nilai', data}],
  xaxis:{categories, labels:{show:false}},
  colors:[color],
  grid:{show:false}
});
new ApexCharts(document.querySelector("#chartProgres"), barOpts(['Jan','Feb','Mar','Apr','Mei','Jun'], [18,29,41,57,69,74], '#2563eb')).render();
new ApexCharts(document.querySelector("#chartStatusProyek"), barOpts(['Berjalan','Selesai','Tertunda','Perlu Perhatian'], [18,9,3,2], '#f59e0b')).render();
new ApexCharts(document.querySelector("#chartRealisasi"), barOpts(['Jalan','Drainase','Gedung','Fasum','RTH'], [76,54,32,20,98], '#10b981')).render();
new ApexCharts(document.querySelector("#chartKategori"), barOpts(['Jalan & Jembatan','Drainase','Gedung Pemerintahan','Fasilitas Umum','Ruang Terbuka Hijau'], [9,7,6,6,5], '#8b5cf6')).render();

const map2 = L.map('map2').setView([-7.4797, 110.2177], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; OpenStreetMap contributors'}).addTo(map2);
L.marker([-7.4797, 110.2177]).addTo(map2);
</script>
</body>
</html>
