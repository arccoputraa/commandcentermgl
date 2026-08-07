<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tentang — Command Center Kota Magelang</title>
<meta name="description" content="Command Center Kota Magelang merupakan platform terintegrasi untuk pemantauan, analisis, dan pelayanan publik seluruh perangkat daerah.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header site-header--shadow">
  <div class="wrap">
    <a class="brand" href="{{ route('home') }}">
      <span class="brand-mark">CM</span>
      <span class="brand-name">Command Center Kota Magelang</span>
    </a>
    <div class="header-right">
      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('tentang') }}" class="active">Tentang</a>
      </nav>
      <a class="btn btn-primary" href="{{ route('login') }}">Login Sistem</a>
      <button class="nav-toggle" aria-label="Buka menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
  <nav class="mobile-nav" aria-label="Navigasi mobile">
    <a href="{{ route('home') }}">Beranda</a>
    <a href="{{ route('tentang') }}" class="active">Tentang</a>
    <a class="btn btn-primary" href="{{ route('login') }}">Login Sistem</a>
  </nav>
</header>

<main>
  <!-- Hero with photo background -->
  <section class="hero hero-sm">
    <div class="wrap">
      <h1>Tentang Command Center Kota Magelang</h1>
      <p>Command Center Kota Magelang merupakan platform terintegrasi yang menghubungkan data dan layanan seluruh perangkat daerah untuk mendukung pemantauan, analisis, dan pelayanan publik yang lebih baik.</p>
    </div>
  </section>

  <!-- Pengenalan -->
  <section class="block" style="padding-bottom:32px;">
    <div class="wrap">
      <div class="about-intro">
        <div class="eyebrow">Pengenalan</div>
        <h2>Apa Itu Command Center?</h2>
        <p>Command Center Kota Magelang berfungsi sebagai pusat kendali digital yang mengintegrasikan data dari seluruh perangkat daerah ke dalam satu platform. Melalui sistem ini, pemerintah kota dapat memantau kondisi layanan publik secara real-time, menganalisis data lintas sektor, dan membuat keputusan yang lebih cepat dan akurat berdasarkan data yang terkini.</p>
      </div>
    </div>
  </section>

  <!-- Tujuan Sistem -->
  <section class="block" style="padding-top:32px;">
    <div class="wrap">
      <h2 class="section-title">Tujuan Sistem</h2>
      <div class="goal-grid">
        <div class="goal-card">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6M9 17h6M9 9h1"/></svg></div>
          <h3>Memusatkan Data Sektoral</h3>
          <p>Mengintegrasikan data dari berbagai divisi dalam satu platform terpusat sehingga mudah diakses dan dikelola.</p>
        </div>
        <div class="goal-card">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></div>
          <h3>Mendukung Pengambilan Keputusan</h3>
          <p>Menyajikan informasi yang ringkas dan visual agar keputusan dapat diambil lebih cepat dan tepat sasaran.</p>
        </div>
        <div class="goal-card">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 2"/></svg></div>
          <h3>Meningkatkan Transparansi Informasi</h3>
          <p>Menyediakan data publik yang dapat diakses masyarakat secara terbuka dan mudah dipahami.</p>
        </div>
        <div class="goal-card">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h4l3 8 4-16 3 8h4"/></svg></div>
          <h3>Mempermudah Monitoring</h3>
          <p>Membantu pemantauan data, layanan, program, dan performa kota secara berkelanjutan.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Ruang Lingkup Data -->
  <section class="block scope-section">
    <div class="wrap">
      <h2 class="section-title">Ruang Lingkup Data</h2>
      <div class="scope-grid">
        <a class="scope-card" href="layanan.blade.php?dept=perizinan">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6M9 17h6M9 9h1"/></svg></div>
          <h3>Perizinan</h3>
          <p>Data layanan perizinan, pengajuan, persetujuan, dan status permohonan.</p>
        </a>
        <a class="scope-card" href="layanan.blade.php?dept=kesehatan">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg></div>
          <h3>Kesehatan</h3>
          <p>Data program kesehatan, penyakit, dan pasien terpantau di fasilitas kesehatan.</p>
        </a>
        <a class="scope-card" href="layanan.blade.php?dept=keuangan">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="14" rx="2"/><path d="M2 10h20"/><path d="M6 15h4"/></svg></div>
          <h3>Keuangan</h3>
          <p>Data anggaran, realisasi, PAD, pajak daerah, dan laporan keuangan.</p>
        </a>
        <a class="scope-card" href="layanan.blade.php?dept=kepegawaian">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
          <h3>Kepegawaian</h3>
          <p>Data pegawai, unit kerja, jabatan, mutasi, dan pengembangan ASN.</p>
        </a>
        <a class="scope-card" href="layanan.blade.php?dept=kependudukan">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="9" cy="12" r="2.2"/><path d="M14 10h5M14 14h5M6 16.2c.6-1.3 1.7-2 3-2s2.4.7 3 2"/></svg></div>
          <h3>Kependudukan</h3>
          <p>Data penduduk, kartu keluarga, agama, wilayah, dan administrasi sipil.</p>
        </a>
        <a class="scope-card" href="layanan.blade.php?dept=pembangunan">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V9l7-5 7 5v12"/><path d="M9 21v-6h6v6"/></svg></div>
          <h3>Pembangunan</h3>
          <p>Data proyek pembangunan, progres fisik, realisasi, dan anggaran infrastruktur.</p>
        </a>
        <a class="scope-card" href="layanan.blade.php?dept=perhubungan">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="6" width="18" height="10" rx="2"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="16.5" cy="18.5" r="1.5"/><path d="M3 11h18"/></svg></div>
          <h3>Perhubungan</h3>
          <p>Data KIR kendaraan, jenis kendaraan, dan rekap pengujian angkutan.</p>
        </a>
        <a class="scope-card" href="layanan.blade.php?dept=sig">
          <div class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><path d="M8 2v16M16 6v16"/></svg></div>
          <h3>SIG</h3>
          <p>Data spasial, peta persebaran, titik lokasi, dan wilayah administrasi.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- Manfaat -->
  <section class="block">
    <div class="wrap">
      <div class="benefit-card">
        <h3>Manfaat Command Center</h3>
        <ul class="benefit-list">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg>
            Data lebih terpusat dan mudah dipantau.
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg>
            Informasi sektoral dapat dibaca melalui grafik dan tabel yang mudah dipahami.
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg>
            Masyarakat dapat melihat data publik tanpa mengakses sistem internal.
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg>
            Setiap divisi memiliki akses dan tanggung jawab data masing-masing.
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="block" style="padding-top:0;">
    <div class="wrap">
      <div class="cta-banner">
        <h2>Jelajahi Data Publik Kota Magelang</h2>
        <p>Temukan informasi sektoral Kota Magelang melalui dashboard interaktif yang mudah diakses kapan saja.</p>
        <div class="cta-actions">
          <a class="btn btn-white" href="index.blade.php#layanan">
            Lihat Data Publik
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </a>
          <a class="btn btn-primary" href="login.blade.php">Login Sistem</a>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer-simple">
  <p class="name">Command Center Kota Magelang</p>
  <p class="copy">© 2026 Pemerintah Kota Magelang. Hak Cipta Dilindungi.</p>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>