<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Command Center Kota Magelang</title>
<meta name="description" content="Pusat Kendali & Data Kota Magelang — platform terintegrasi untuk pemantauan, analisis, dan layanan publik.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body data-cctv-limit="6">

<header class="site-header">
  <div class="wrap">
    <a class="brand" href="index.html">
      <span class="brand-mark">CM</span>
      <span class="brand-name">Command Center Kota Magelang</span>
    </a>
    <div class="header-right">
      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="index.html" class="active">Beranda</a>
        <a href="tentang.html">Tentang</a>
      </nav>
      <a class="btn btn-primary" href="login.html">Login Sistem</a>
      <button class="nav-toggle" aria-label="Buka menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
  <nav class="mobile-nav" aria-label="Navigasi mobile">
    <a href="index.html" class="active">Beranda</a>
    <a href="tentang.html">Tentang</a>
    <a class="btn btn-primary" href="login.html">Login Sistem</a>
  </nav>
</header>

<main>
  <section class="hero">
    <div class="wrap">
      <h1>Pusat Kendali &amp; Data <span class="hero-city">Kota Magelang</span></h1>
      <p>Platform terintegrasi untuk pemantauan, analisis, dan layanan publik seluruh perangkat daerah Kota Magelang dalam satu tempat.</p>
      <div class="hero-ctas">
      </div>
    </div>
  </section>

  <section class="block" id="layanan">
    <div class="wrap">
      <div class="section-head">
        <h2>Layanan &amp; Data Publik</h2>
        <p>Akses data terbuka dari setiap perangkat daerah Kota Magelang.</p>
      </div>
      <div class="card-grid" data-service-grid></div>
    </div>
  </section>

  <section class="block" id="cctv" style="background:#F8FAFC;">
    <div class="wrap">
      <div class="section-head">
        <h2>Monitoring CCTV Publik</h2>
        <p>Pantau beberapa titik CCTV publik Kota Magelang secara langsung.</p>
      </div>
      <div class="cctv-grid" data-cctv-grid></div>
      <div class="cctv-more">
        <a class="btn btn-primary" href="cctv.html">Lihat Semua</a>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
  <div class="wrap">
    <div class="footer-brand">
      <h5>Command Center Kota Magelang</h5>
      <p>Platform pusat kendali dan data terintegrasi milik Pemerintah Kota Magelang untuk mendukung pemantauan, analisis, dan pelayanan publik yang transparan.</p>
    </div>
    <div>
      <h5>Navigasi</h5>
      <ul>
        <li><a href="index.html">Beranda</a></li>
        <li><a href="tentang.html">Tentang</a></li>
        <li><a href="cctv.html">CCTV Publik</a></li>
        <li><a href="login.html">Login Sistem</a></li>
      </ul>
    </div>
    <div>
      <h5>Layanan</h5>
      <ul>
        <li><a href="layanan.html?dept=perizinan">Perizinan</a></li>
        <li><a href="layanan.html?dept=kesehatan">Kesehatan</a></li>
        <li><a href="layanan.html?dept=keuangan">Keuangan</a></li>
        <li><a href="layanan.html?dept=kependudukan">Kependudukan</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">© 2026 Pemerintah Kota Magelang. Seluruh hak cipta dilindungi.</div>
</footer>

<script src="app.js"></script>
</body>
</html>