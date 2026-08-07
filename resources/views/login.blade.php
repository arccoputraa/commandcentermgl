<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Sistem — Command Center Kota Magelang</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<header class="site-header site-header--shadow">
  <div class="wrap">
    <a class="brand" href="index.html">
      <span class="brand-mark">CM</span>
      <span class="brand-name">Command Center Kota Magelang</span>
    </a>
    <div class="header-right">
      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="index.html">Beranda</a>
        <a href="tentang.html">Tentang</a>
      </nav>
      <button class="nav-toggle" aria-label="Buka menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
  <nav class="mobile-nav" aria-label="Navigasi mobile">
    <a href="index.html">Beranda</a>
    <a href="tentang.html">Tentang</a>
  </nav>
</header>

<main>
  <div class="login-hero">
    <div class="login-card-split">

      <!-- Left: visual / branding panel -->
      <section class="login-visual">
        <div class="blob"></div>
        <div class="lv-content">
          <div class="badge">
            <span class="mark"><span>CM</span></span>
            <div class="txt">
              <b>Command Center</b>
              <span>Kota Magelang</span>
            </div>
          </div>
          <div class="eyebrow-cyan">Secure Government Data Access</div>
          <h1>Masuk ke pusat kendali data sektoral.</h1>
          <p>Akses dashboard internal sesuai akun dan hak akses yang telah diberikan oleh administrator sistem.</p>
        </div>
      </section>

      <!-- Right: form panel -->
      <section class="login-form-side">
        <div class="login-form-inner">
          <div class="lock-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
          <h2>Login Sistem</h2>
          <p class="sub">Masukkan username dan password akun resmi Anda.</p>

          <form id="login-form" novalidate>
            <div class="input-group">
              <label for="username">Username / Email</label>
              <div class="input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <input type="text" id="username" name="username" autocomplete="username" required placeholder="Masukkan username">
              </div>
            </div>

            <div class="input-group">
              <div class="row-between">
                <label for="password">Password</label>
                <a class="forgot" href="#" onclick="alert('Demo: hubungi admin Diskominfo untuk reset kata sandi.'); return false;">Lupa Password?</a>
              </div>
              <div class="input-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input type="password" id="password" name="password" autocomplete="current-password" required placeholder="Masukkan password">
              </div>
            </div>

            <button type="submit" class="login-submit">
              Masuk Sistem
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
            <div class="login-form-msg" role="status"></div>
          </form>
        </div>
      </section>

    </div>
  </div>
</main>

<script src="app.js"></script>
</body>
</html>