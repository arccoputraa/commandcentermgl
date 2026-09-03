<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Sistem — Command Center Kota Magelang</title>
<link rel="icon" href="{{ asset('images/cmdcenterlogo.png') }}" type="image/png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/style.css', 'resources/js/app.js'])
</head>
<body class="login-page">

<header class="site-header site-header--shadow">
  <div class="wrap">
    <a class="brand" href="{{ route('home') }}">
      <img class="brand-mark" src="{{ asset('images/cmdcenterlogo.png') }}" alt="Command Center Kota Magelang" />
      <span class="brand-name">Command Center Kota Magelang</span>
    </a>
    <div class="header-right">
      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('tentang') }}">Tentang</a>
        <div class="nav-dropdown">
            <button class="nav-dropdown-btn">Layanan Divisi &#9662;</button>
            <div class="nav-dropdown-content">
                <a href="{{ route('layanan', ['dept' => 'kependudukan']) }}">Kependudukan</a>
                <a href="{{ route('layanan', ['dept' => 'kesehatan']) }}">Kesehatan</a>
                <a href="{{ route('layanan', ['dept' => 'perizinan']) }}">Perizinan</a>
                <a href="{{ route('layanan', ['dept' => 'pembangunan']) }}">Pembangunan</a>
                <a href="{{ route('layanan', ['dept' => 'keuangan']) }}">Keuangan</a>
                <a href="{{ route('layanan', ['dept' => 'kepegawaian']) }}">Kepegawaian</a>
                <a href="{{ route('layanan', ['dept' => 'perhubungan']) }}">Perhubungan</a>
                <a href="{{ route('layanan', ['dept' => 'sig']) }}">SIG</a>
            </div>
        </div>
      </nav>
      <button class="nav-toggle" aria-label="Buka menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      </button>
    </div>
  </div>
  <nav class="mobile-nav" aria-label="Navigasi mobile">
    <a href="{{ route('home') }}">Beranda</a>
    <a href="{{ route('tentang') }}">Tentang</a>
    <div style="padding: 12px 0; border-bottom: 1px solid var(--slate-100);">
        <div style="font-weight: 600; color: var(--slate-600); margin-bottom: 8px;">Layanan Divisi</div>
        <div style="display: flex; flex-direction: column; padding-left: 12px; gap: 8px;">
            <a href="{{ route('layanan', ['dept' => 'kependudukan']) }}" style="border: none; padding: 4px 0;">Kependudukan</a>
            <a href="{{ route('layanan', ['dept' => 'kesehatan']) }}" style="border: none; padding: 4px 0;">Kesehatan</a>
            <a href="{{ route('layanan', ['dept' => 'perizinan']) }}" style="border: none; padding: 4px 0;">Perizinan</a>
            <a href="{{ route('layanan', ['dept' => 'pembangunan']) }}" style="border: none; padding: 4px 0;">Pembangunan</a>
            <a href="{{ route('layanan', ['dept' => 'keuangan']) }}" style="border: none; padding: 4px 0;">Keuangan</a>
            <a href="{{ route('layanan', ['dept' => 'kepegawaian']) }}" style="border: none; padding: 4px 0;">Kepegawaian</a>
            <a href="{{ route('layanan', ['dept' => 'perhubungan']) }}" style="border: none; padding: 4px 0;">Perhubungan</a>
            <a href="{{ route('layanan', ['dept' => 'sig']) }}" style="border: none; padding: 4px 0;">SIG</a>
        </div>
    </div>
  </nav>
</header>

<main>
  <div class="login-hero" style="--container-image: url('{{ asset('images/container.png') }}');">
    <div class="login-card-split">

      <!-- Left: visual / branding panel -->
      <section class="login-visual">
        <div class="blob"></div>
        <div class="lv-content">
          <div class="badge">
            <span class="mark">
              <img src="{{ asset('images/cmdcenterlogo.png') }}" alt="Command Center Kota Magelang" style="width: 28px; height: 28px; object-fit: contain;" />
            </span>
            <div class="txt">
              <b>Command Center</b>
              <span>Kota Magelang</span>
            </div>
          </div>
          <div class="eyebrow-cyan">Secure Government Data Access</div>
          <h1>Masuk ke pusat kendali data sektoral.</h1>
          <p>Akses dashboard internal sesuai akun dan hak akses masing-masing divisi. Sistem otomatis mengarahkan pengguna ke ruang kerja yang berwenang.</p>
        </div>
      </section>

      <!-- Right: form panel -->
      <section class="login-form-side">
        <div class="login-form-inner">
          <div class="lock-badge">
            <img src="{{ asset('images/cmdcenterlogo.png') }}" alt="Logo Command Center" style="width: 36px; height: 36px; object-fit: contain;" />
          </div>
          <h2>Login Sistem</h2>
          <p class="sub">Masukkan username dan password akun resmi Anda.</p>

          <form id="login-form" method="POST" action="{{ route('login.post') }}">
            @csrf
            
            @if($errors->any())
              <div style="background-color: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                {{ $errors->first() }}
              </div>
            @endif

            <div class="input-group">
              <label for="username">Username / Email</label>
              <div class="input-wrap">
                <input type="email" id="username" name="email" value="{{ old('email') }}" autocomplete="email" required placeholder="Masukkan username">
              </div>
            </div>

            <div class="input-group">
              <div class="row-between">
                <label for="password">Password</label>
                <a class="forgot" href="#" onclick="alert('Demo: hubungi admin Diskominfo untuk reset kata sandi.'); return false;">Lupa Password?</a>
              </div>
              <div class="input-wrap">
                <input type="password" id="password" name="password" autocomplete="current-password" required placeholder="Masukkan password">
              </div>
            </div>

            <button type="submit" class="login-submit">
              Masuk Sistem
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
          </form>
        </div>
      </section>

    </div>
  </div>
</main>
</body>
</html>
