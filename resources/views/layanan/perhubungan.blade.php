<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perhubungan - Command Center Kota Magelang</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>body{font-family:'Plus Jakarta Sans',sans-serif;}</style>
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
  <a href="home.html" class="hover:text-blue-600">Beranda</a> <span class="mx-1">›</span> <span class="text-slate-700">Data Perhubungan</span>
</div>

<main class="max-w-7xl mx-auto px-6 py-6 space-y-6">

  <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-sky-50 to-blue-50 border border-blue-100 p-8">
    <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-blue-200/40 blur-2xl"></div>
    <div class="relative">
      <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Pusat Data Perhubungan</h1>
      <p class="text-slate-600 mt-1 max-w-xl">Informasi publik dan statistik sektoral perhubungan Kota Magelang.</p>
    </div>
  </section>

  <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Total KIR Kendaraan</p><p class="text-2xl font-bold mt-1">7.064 Unit</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">KIR Bulan Ini</p><p class="text-2xl font-bold mt-1">163 Unit</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Lulus Uji</p><p class="text-2xl font-bold mt-1">145 Unit</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Tidak Lulus</p><p class="text-2xl font-bold mt-1">12 Unit</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Perlu Uji Ulang</p><p class="text-2xl font-bold mt-1">6 Unit</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Update Terakhir</p><p class="text-lg font-bold mt-1">03 Jul 2026</p></div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-wrap gap-3 items-center">
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Jenis Kendaraan</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Bulan</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Status</option></select>
    <div class="flex-1 min-w-[160px] relative">
      <span class="absolute left-3 top-2.5 text-slate-400 text-sm">🔍</span>
      <input placeholder="Search kendaraan/indikator" class="w-full border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm">
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Terapkan Filter</button>
  </section>

  <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Komposisi Jenis Kendaraan</h3>
      <div id="chartJenis"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Tren KIR Kendaraan per Bulan</h3>
      <div id="chartTren"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Status Hasil Uji KIR</h3>
      <div id="chartStatus"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">KIR Berdasarkan Jenis Kendaraan</h3>
      <div id="chartKirJenis"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Layanan KIR Berdasarkan Unit</h3>
      <div id="chartUnit"></div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi Terbaru</h3>
      <div class="space-y-3">
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Rekap KIR Kendaraan Semester I 2026</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Rekap KIR Kendaraan · 03 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Informasi Jadwal Layanan KIR Juli 2026</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Informasi Layanan KIR · 02 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Laporan Pengujian Kendaraan Juni 2026</p><span class="text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Draft</span></div>
          <p class="text-xs text-slate-400 mt-1">Laporan Pengujian Kendaraan · 01 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Pengumuman Layanan Perhubungan</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Pengumuman Perhubungan · 03 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="p-4 border-b border-slate-100"><h3 class="text-sm font-semibold text-slate-700">Tabel Ringkas KIR Kendaraan</h3></div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
          <tr>
            <th class="text-left px-4 py-3 font-medium">Bulan/Tahun</th>
            <th class="text-left px-4 py-3 font-medium">Jenis Kendaraan</th>
            <th class="text-left px-4 py-3 font-medium">Total KIR</th>
            <th class="text-left px-4 py-3 font-medium">Lulus Uji</th>
            <th class="text-left px-4 py-3 font-medium">Tidak Lulus</th>
            <th class="text-left px-4 py-3 font-medium">Perlu Uji Ulang</th>
            <th class="text-left px-4 py-3 font-medium">Keterangan</th>
            <th class="text-left px-4 py-3 font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr><td class="px-4 py-3">Januari 2026</td><td class="px-4 py-3">Mobil Barang Bak Tertutup</td><td class="px-4 py-3">152 Unit</td><td class="px-4 py-3">136</td><td class="px-4 py-3">10</td><td class="px-4 py-3">6</td><td class="px-4 py-3 text-green-600 font-medium">Data Terbaru</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">Februari 2026</td><td class="px-4 py-3">Truk Pengangkut</td><td class="px-4 py-3">148 Unit</td><td class="px-4 py-3">131</td><td class="px-4 py-3">11</td><td class="px-4 py-3">6</td><td class="px-4 py-3 text-green-600 font-medium">Data Terbaru</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">Maret 2026</td><td class="px-4 py-3">Mobil Bus Kecil</td><td class="px-4 py-3">171 Unit</td><td class="px-4 py-3">150</td><td class="px-4 py-3">14</td><td class="px-4 py-3">7</td><td class="px-4 py-3 text-green-600 font-medium">Data Terbaru</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">April 2026</td><td class="px-4 py-3">Mobil Barang Bak Besar</td><td class="px-4 py-3">160 Unit</td><td class="px-4 py-3">142</td><td class="px-4 py-3">12</td><td class="px-4 py-3">6</td><td class="px-4 py-3 text-green-600 font-medium">Data Terbaru</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">Mei 2026</td><td class="px-4 py-3">Mobil Penarik</td><td class="px-4 py-3">163 Unit</td><td class="px-4 py-3">145</td><td class="px-4 py-3">12</td><td class="px-4 py-3">6</td><td class="px-4 py-3 text-green-600 font-medium">Data Terbaru</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
        </tbody>
      </table>
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
  series:[{name:'Total', data}],
  xaxis:{categories, labels:{show:false}},
  colors:[color],
  grid:{show:false}
});

new ApexCharts(document.querySelector("#chartJenis"), barOpts(
  ['Barang Bak Tertutup','Truk Pengangkut','Bus Kecil','Barang Bak Besar','Penarik','Bus Sedan','Bus Besar','Motor'],
  [1240,1120,980,860,640,520,430,312], '#2563eb')).render();

new ApexCharts(document.querySelector("#chartTren"), barOpts(
  ['Januari','Februari','Maret','April','Mei'], [152,148,171,160,163], '#10b981')).render();

new ApexCharts(document.querySelector("#chartStatus"), barOpts(
  ['Lulus','Tidak Lulus','Perlu Uji Ulang'], [145,12,6], '#f59e0b')).render();

new ApexCharts(document.querySelector("#chartKirJenis"), barOpts(
  ['JN-001','JN-002','JN-003','JN-004','JN-005','JN-006'], [1240,1120,860,860,640,520], '#8b5cf6')).render();

new ApexCharts(document.querySelector("#chartUnit"), barOpts(
  ['UPT-KIR-01','POS-TRM-01','POS-BRO-01'], [6820,124,120], '#0ea5e9')).render();
</script>
</body>
</html>
