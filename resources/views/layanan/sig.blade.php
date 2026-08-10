<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIG - Command Center Kota Magelang</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  body{font-family:'Plus Jakarta Sans',sans-serif;}
  #map{height:100%;width:100%;border-radius:.75rem;}
</style>
</head>
<body class="bg-slate-50 text-slate-800">

<!-- Topbar -->
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
  <a href="home.html" class="hover:text-blue-600">Beranda</a> <span class="mx-1">›</span> <span class="text-slate-700">Data SIG</span>
</div>

<main class="max-w-7xl mx-auto px-6 py-6 space-y-6">

  <!-- Hero -->
  <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-100 p-8">
    <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-blue-200/40 blur-2xl"></div>
    <div class="relative">
      <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Pusat Data SIG</h1>
      <p class="text-slate-600 mt-1 max-w-xl">Informasi publik dan statistik spasial Kota Magelang.</p>
    </div>
  </section>

  <!-- Filter bar -->
  <section class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-wrap gap-3 items-center">
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Kecamatan</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Kategori</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Tahun</option></select>
    <div class="flex-1 min-w-[160px] relative">
      <span class="absolute left-3 top-2.5 text-slate-400 text-sm">🔍</span>
      <input placeholder="Search indikator" class="w-full border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm">
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Terapkan Filter</button>
  </section>

  <!-- Layer + Map -->
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-sm font-semibold text-slate-500 tracking-wide mb-3">Layer Publik</h3>
      <div class="flex flex-col gap-1" x-data="{active:'Mata Air'}">
        <template x-for="layer in ['Mata Air','Kemiskinan','Bahaya Banjir','Distribusi Pangan','Bahaya Gempa','Distribusi Sanitasi','Kerentanan Pangan','Volume to Capacity Ratio','Batas Wilayah Administrasi']">
          <button @click="active=layer" :class="active===layer ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-50'" class="text-left text-sm px-3 py-2.5 rounded-lg transition" x-text="layer"></button>
        </template>
      </div>
    </div>
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-4">
      <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-semibold text-slate-700">Peta Utama: Mata Air</h3>
        <span class="text-xs text-blue-600 font-medium">Layer Aktif</span>
      </div>
      <div id="map" class="h-80"></div>
    </div>
  </section>

  <!-- Stat cards -->
  <section class="grid grid-cols-2 md:grid-cols-5 gap-4">
    <template x-data="{items:[
      {label:'RUMAH SANITASI', val:15},
      {label:'SUMUR RESAPAN', val:15},
      {label:'WIFI', val:15},
      {label:'RUANG TERBUKA HIJAU', val:15},
      {label:'UMKM', val:15},
    ]}">
      <template x-for="it in items">
        <div class="bg-white rounded-2xl border border-slate-200 p-4">
          <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium" x-text="it.label"></p>
          <p class="text-2xl font-bold text-slate-800 mt-1" x-text="it.val"></p>
          <button class="mt-3 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-slate-600 hover:bg-slate-50">Lihat Data</button>
        </div>
      </template>
    </template>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">CCTV</p>
      <p class="text-2xl font-bold text-slate-800 mt-1">15</p>
      <button class="mt-3 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-slate-600 hover:bg-slate-50">Lihat Data</button>
    </div>
  </section>

  <!-- Table + Info -->
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 overflow-hidden">
      <div class="p-4 border-b border-slate-100"><h3 class="text-sm font-semibold text-slate-700">Tabel Data SIG Publik</h3></div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
              <th class="text-left px-4 py-3 font-medium">Nama Data</th>
              <th class="text-left px-4 py-3 font-medium">Kategori</th>
              <th class="text-left px-4 py-3 font-medium">Wilayah</th>
              <th class="text-left px-4 py-3 font-medium">Nilai/Jumlah</th>
              <th class="text-left px-4 py-3 font-medium">Update Terakhir</th>
              <th class="text-left px-4 py-3 font-medium">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr>
              <td class="px-4 py-3">Sanitasi Tidar Selatan 01</td><td class="px-4 py-3">Rumah Sanitasi</td><td class="px-4 py-3">Tidar Selatan</td><td class="px-4 py-3">1 Titik</td><td class="px-4 py-3">03 Jul 2026</td>
              <td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td>
            </tr>
            <tr>
              <td class="px-4 py-3">Sumur Resapan Panjang 02</td><td class="px-4 py-3">Sumur Resapan</td><td class="px-4 py-3">Panjang</td><td class="px-4 py-3">1 Titik</td><td class="px-4 py-3">03 Jul 2026</td>
              <td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td>
            </tr>
            <tr>
              <td class="px-4 py-3">WiFi Alun-Alun Kota</td><td class="px-4 py-3">WiFi</td><td class="px-4 py-3">Kemirirejo</td><td class="px-4 py-3">1 Titik</td><td class="px-4 py-3">02 Jul 2026</td>
              <td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td>
            </tr>
            <tr>
              <td class="px-4 py-3">Taman Kedungsari Hijau</td><td class="px-4 py-3">Ruang Terbuka Hijau</td><td class="px-4 py-3">Kedungsari</td><td class="px-4 py-3">1 Titik</td><td class="px-4 py-3">02 Jul 2026</td>
              <td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td>
            </tr>
            <tr>
              <td class="px-4 py-3">Sentra UMKM Rejowinangun</td><td class="px-4 py-3">UMKM</td><td class="px-4 py-3">Rejowinangun</td><td class="px-4 py-3">1 Titik</td><td class="px-4 py-3">01 Jul 2026</td>
              <td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td>
            </tr>
            <tr>
              <td class="px-4 py-3">CCTV Simpang Trio</td><td class="px-4 py-3">CCTV</td><td class="px-4 py-3">Panjang</td><td class="px-4 py-3">1 Titik</td><td class="px-4 py-3">01 Jul 2026</td>
              <td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi Terbaru</h3>
      <div class="space-y-3">
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-800">Laporan SIG Semester I 2026</p>
            <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span>
          </div>
          <p class="text-xs text-slate-400 mt-1">Laporan SIG · 03 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-800">Peta Tematik Sanitasi Kota</p>
            <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span>
          </div>
          <p class="text-xs text-slate-400 mt-1">Peta Tematik · 02 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-800">Analisis Kerentanan Pangan 2026</p>
            <span class="text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Draft</span>
          </div>
          <p class="text-xs text-slate-400 mt-1">Analisis Spasial · 01 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-800">Publikasi Titik CCTV Kota</p>
            <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span>
          </div>
          <p class="text-xs text-slate-400 mt-1">Publikasi Fasilitas Kota · 30 Jun 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="bg-slate-900 text-slate-400 text-center text-xs py-6 mt-10">
  Command Center Kota Magelang<br>© 2026 Pemerintah Kota Magelang. Hak Cipta Dilindungi.
</footer>

<script>
  const map = L.map('map').setView([-7.4797, 110.2177], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);
  L.marker([-7.4797, 110.2177]).addTo(map).bindPopup('Kota Magelang');
</script>
</body>
</html>
