<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kepegawaian - Command Center Kota Magelang</title>
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
  <a href="home.html" class="hover:text-blue-600">Beranda</a> <span class="mx-1">›</span> <span class="text-slate-700">Data Kepegawaian</span>
</div>

<main class="max-w-7xl mx-auto px-6 py-6 space-y-6">

  <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100 p-8">
    <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full bg-indigo-200/40 blur-2xl"></div>
    <div class="relative">
      <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Pusat Data Kepegawaian</h1>
      <p class="text-slate-600 mt-1 max-w-xl">Informasi publik dan statistik sektoral kepegawaian Kota Magelang.</p>
    </div>
  </section>

  <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Total Pegawai</p><p class="text-2xl font-bold mt-1">126</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">PNS</p><p class="text-2xl font-bold mt-1">83</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">PPPK</p><p class="text-2xl font-bold mt-1">25</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Non-ASN</p><p class="text-2xl font-bold mt-1">18</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Pegawai Aktif</p><p class="text-2xl font-bold mt-1">121</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Mendekati Pensiun</p><p class="text-2xl font-bold mt-1">5</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Mutasi Tahun Ini</p><p class="text-2xl font-bold mt-1">12</p></div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4"><p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Update Terakhir</p><p class="text-lg font-bold mt-1">03 Jul 2026</p></div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 p-4 flex flex-wrap gap-3 items-center">
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Unit Kerja</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Golongan</option></select>
    <select class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-500 flex-1 min-w-[140px]"><option>Status</option></select>
    <div class="flex-1 min-w-[160px] relative">
      <span class="absolute left-3 top-2.5 text-slate-400 text-sm">🔍</span>
      <input placeholder="Search indikator" class="w-full border border-slate-200 rounded-lg pl-9 pr-3 py-2 text-sm">
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg">Terapkan Filter</button>
  </section>

  <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Komposisi Jenis Pegawai</h3>
      <div id="chartJenisPegawai"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Pegawai Berdasarkan Unit Kerja</h3>
      <div id="chartUnitKerja"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Komposisi Jenis Kelamin</h3>
      <div id="chartGenderPeg"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Pegawai Berdasarkan Golongan</h3>
      <div id="chartGolongan"></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-xs font-semibold text-slate-500 tracking-wide uppercase mb-2">Tren Mutasi dan Pensiun</h3>
      <div id="chartMutasi"></div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-4">
      <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi Terbaru</h3>
      <div class="space-y-3">
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Rekap Data Pegawai Semester I 2026</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Rekap Data Pegawai · 03 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Informasi Mutasi Pegawai Juni 2026</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Mutasi Pegawai · 02 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Jadwal Pensiun Pegawai 2026</p><span class="text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Draft</span></div>
          <p class="text-xs text-slate-400 mt-1">Pensiun Pegawai · 01 Jul 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
        <div class="border border-slate-100 rounded-xl p-3">
          <div class="flex items-center justify-between"><p class="text-sm font-medium">Publikasi Komposisi ASN Kota Magelang</p><span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Rilis</span></div>
          <p class="text-xs text-slate-400 mt-1">Statistik Pegawai · 30 Jun 2026</p>
          <a href="#" class="inline-block mt-2 text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat PDF</a>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="p-4 border-b border-slate-100"><h3 class="text-sm font-semibold text-slate-700">Tabel Ringkas Data Kepegawaian</h3></div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
          <tr>
            <th class="text-left px-4 py-3 font-medium">Tahun</th>
            <th class="text-left px-4 py-3 font-medium">Kategori</th>
            <th class="text-left px-4 py-3 font-medium">Unit Kerja</th>
            <th class="text-left px-4 py-3 font-medium">Jumlah Pegawai</th>
            <th class="text-left px-4 py-3 font-medium">Keterangan</th>
            <th class="text-left px-4 py-3 font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr><td class="px-4 py-3">2026</td><td class="px-4 py-3">PNS</td><td class="px-4 py-3">Sekretariat</td><td class="px-4 py-3">18 Pegawai</td><td class="px-4 py-3 text-green-600 font-medium">Aktif</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">2026</td><td class="px-4 py-3">PPPK</td><td class="px-4 py-3">Bidang Pengembangan SDM</td><td class="px-4 py-3">9 Pegawai</td><td class="px-4 py-3 text-green-600 font-medium">Aktif</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">2026</td><td class="px-4 py-3">Non-ASN</td><td class="px-4 py-3">Sekretariat</td><td class="px-4 py-3">6 Pegawai</td><td class="px-4 py-3 text-green-600 font-medium">Aktif</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">2026</td><td class="px-4 py-3">Mendekati Pensiun</td><td class="px-4 py-3">Bidang Data Kepegawaian</td><td class="px-4 py-3">3 Pegawai</td><td class="px-4 py-3 text-amber-600 font-medium">Terjadwal</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
          <tr><td class="px-4 py-3">2026</td><td class="px-4 py-3">Mutasi Internal</td><td class="px-4 py-3">Bidang Mutasi</td><td class="px-4 py-3">4 Pegawai</td><td class="px-4 py-3 text-blue-600 font-medium">Selesai</td><td class="px-4 py-3"><a href="#" class="text-xs border border-slate-200 rounded-lg px-3 py-1.5 text-blue-600 hover:bg-blue-50">Lihat Detail</a></td></tr>
        </tbody>
      </table>
    </div>
  </section>
</main>

<footer class="bg-slate-900 text-slate-400 text-center text-xs py-6 mt-10">
  Command Center Kota Magelang<br>© 2026 Pemerintah Kota Magelang. Hak Cipta Dilindungi.
</footer>

<script>
const donutOpts = (labels, series, colors) => ({
  chart:{type:'donut', height:220},
  series, labels, colors,
  legend:{position:'bottom', fontSize:'12px'},
  dataLabels:{enabled:false},
  plotOptions:{pie:{donut:{labels:{show:true,total:{show:true,label:'Total'}}}}}
});
const barOpts = (categories, data, color) => ({
  chart:{type:'bar', height:220, toolbar:{show:false}},
  plotOptions:{bar:{horizontal:true, borderRadius:4, barHeight:'55%'}},
  dataLabels:{enabled:true, style:{colors:['#334155']}, offsetX:20},
  series:[{name:'Jumlah', data}],
  xaxis:{categories, labels:{show:false}},
  colors:[color],
  grid:{show:false}
});

new ApexCharts(document.querySelector("#chartJenisPegawai"), donutOpts(['PNS','PPPK','Non-ASN'], [83,25,18], ['#2563eb','#10b981','#f59e0b'])).render();
new ApexCharts(document.querySelector("#chartUnitKerja"), barOpts(['Sekretariat','Data Kepegawaian','Mutasi','Pengembangan SDM','Kesejahteraan'], [28,54,21,25,18], '#6366f1')).render();
new ApexCharts(document.querySelector("#chartGenderPeg"), donutOpts(['Laki-laki','Perempuan'], [58,68], ['#2563eb','#ec4899'])).render();
new ApexCharts(document.querySelector("#chartGolongan"), barOpts(['Golongan II','Golongan III','Golongan IV','PPPK','Non-ASN'], [18,54,11,25,18], '#10b981')).render();
new ApexCharts(document.querySelector("#chartMutasi"), barOpts(['Jan','Feb','Mar','Apr','Mei','Jun'], [2,4,3,5,8,12], '#f59e0b')).render();
</script>
</body>
</html>
