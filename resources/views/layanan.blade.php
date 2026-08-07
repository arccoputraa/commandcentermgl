<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Layanan &amp; Data Publik — Command Center Kota Magelang</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/style.css', 'resources/js/app.js'])
</head>
<body data-dept-page>

<header class="site-header">
  <div class="wrap">
    <a class="brand" href="{{ route('home') }}">
      <img class="brand-mark" src="{{ asset('images/cmdcenterlogo.png') }}" alt="Command Center Kota Magelang" />
      <span class="brand-name">Command Center <span class="brand-city">Kota Magelang</span><span class="brand-subtitle">Pusat Kendali &amp; Data Kota</span></span>
    </a>
    <div class="header-right">
      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('tentang') }}">Tentang</a>
      </nav>
      <a class="btn btn-primary" href="{{ route('login') }}">Login Sistem</a>
      <button class="nav-toggle" aria-label="Buka menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
  <nav class="mobile-nav" aria-label="Navigasi mobile">
    <a href="{{ route('home') }}">Beranda</a>
    <a href="{{ route('tentang') }}">Tentang</a>
    <a class="btn btn-primary" href="{{ route('login') }}">Login Sistem</a>
  </nav>
</header>

<main>
  <section class="page-hero">
    <div class="wrap">
      <div class="breadcrumb"><a href="index.blade.php">Beranda</a> / Layanan / <span data-dept-name>...</span></div>
      <div class="dept-hero-icon" data-dept-icon></div>
      <h1 data-dept-name>...</h1>
      <p data-dept-office>...</p>
      <div class="dept-meta">
        <span class="chip">Data terbuka</span>
        <span class="chip">Diperbarui berkala</span>
      </div>
    </div>
  </section>

  <section class="block">
    <div class="wrap content-narrow">
      <h2>Tentang Layanan</h2>
      <p data-dept-about>...</p>

      <div class="stat-grid" data-dept-stats></div>

      <h2>Dataset &amp; Dokumen Publik</h2>
      <p>Unduh dataset terbaru yang dipublikasikan oleh perangkat daerah terkait.</p>
      <ul class="dataset-list" data-dept-datasets></ul>

      <h2>Layanan Lain</h2>
      <p>Jelajahi data publik dari perangkat daerah lainnya.</p>
      <div class="dept-nav" data-dept-nav></div>
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
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('tentang') }}">Tentang</a></li>
        <li><a href="{{ route('cctv') }}">CCTV Publik</a></li>
        <li><a href="{{ route('login') }}">Login Sistem</a></li>
      </ul>
    </div>
    <div>
      <h5>Layanan</h5>
      <ul>
        <li><a href="layanan.blade.php?dept=perizinan">Perizinan</a></li>
        <li><a href="layanan.blade.php?dept=kesehatan">Kesehatan</a></li>
        <li><a href="layanan.blade.php?dept=keuangan">Keuangan</a></li>
        <li><a href="layanan.blade.php?dept=kependudukan">Kependudukan</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">© 2026 Pemerintah Kota Magelang. Seluruh hak cipta dilindungi.</div>
</footer>
</body>
</html>
