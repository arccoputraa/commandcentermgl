// ============================================================
// Command Center Kota Magelang — shared app logic
// ============================================================

// ---------- Mobile nav toggle ----------
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav-toggle');
  if (toggle) {
    toggle.addEventListener('click', () => {
      document.body.classList.toggle('nav-open');
      const mobileNav = document.querySelector('.mobile-nav');
      if (mobileNav) {
        mobileNav.style.display = document.body.classList.contains('nav-open') ? 'flex' : 'none';
      }
    });
  }
});

// ---------- Icon library (inline SVG strings, stroke = currentColor) ----------
const ICONS = {
  perizinan: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6M9 17h6M9 9h1"/></svg>`,
  kesehatan: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>`,
  keuangan: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="14" rx="2"/><path d="M2 10h20"/><path d="M6 15h4"/></svg>`,
  kepegawaian: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>`,
  kependudukan: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="9" cy="12" r="2.2"/><path d="M14 10h5M14 14h5M6 16.2c.6-1.3 1.7-2 3-2s2.4.7 3 2"/></svg>`,
  pembangunan: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V9l7-5 7 5v12"/><path d="M9 21v-6h6v6"/></svg>`,
  perhubungan: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="6" width="18" height="10" rx="2"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="16.5" cy="18.5" r="1.5"/><path d="M3 11h18"/></svg>`,
  sig: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><path d="M8 2v16M16 6v16"/></svg>`,
  camera: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2Z"/><circle cx="12" cy="13" r="4"/></svg>`,
  file: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>`
};

// ---------- Department (Layanan Publik) dataset ----------
const DEPARTMENTS = {
  perizinan: {
    name: 'Perizinan',
    office: 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
    short: 'Layanan izin usaha, IMB, dan perizinan terpadu satu pintu.',
    icon: 'perizinan',
    about: 'DPMPTSP mengelola seluruh proses perizinan dan non-perizinan Kota Magelang secara terpadu, mulai dari izin usaha mikro kecil hingga izin mendirikan bangunan, dengan target percepatan waktu layanan dan transparansi proses.',
    stats: [ ['12', 'Jenis izin daring'], ['3-7', 'Hari proses rata-rata'], ['24/7', 'Pendaftaran online'], ['0', 'Biaya calo'] ],
    datasets: [
      { name: 'Rekap Izin Usaha 2026 (Semester 1)', meta: 'XLSX · Diperbarui 2 Agu 2026' },
      { name: 'Data IMB Terbit per Kecamatan', meta: 'CSV · Diperbarui 30 Jul 2026' },
      { name: 'Panduan Alur Perizinan OSS-RBA', meta: 'PDF · Diperbarui 15 Jun 2026' }
    ]
  },
  kesehatan: {
    name: 'Kesehatan',
    office: 'Dinas Kesehatan',
    short: 'Data fasilitas kesehatan, imunisasi, dan indikator kesehatan warga.',
    icon: 'kesehatan',
    about: 'Dinas Kesehatan Kota Magelang menyediakan data terbuka seputar puskesmas, cakupan imunisasi, gizi balita, dan indikator kesehatan masyarakat untuk mendukung pengambilan kebijakan berbasis data.',
    stats: [ ['12', 'Puskesmas aktif'], ['98%', 'Cakupan imunisasi dasar'], ['4', 'Rumah sakit rujukan'], ['150+', 'Posyandu aktif'] ],
    datasets: [
      { name: 'Sebaran Fasilitas Kesehatan', meta: 'XLSX · Diperbarui 28 Jul 2026' },
      { name: 'Cakupan Imunisasi per Kelurahan', meta: 'CSV · Diperbarui 20 Jul 2026' },
      { name: 'Laporan Status Gizi Balita', meta: 'PDF · Diperbarui 5 Jul 2026' }
    ]
  },
  keuangan: {
    name: 'Keuangan',
    office: 'Badan Pengelolaan Keuangan dan Aset Daerah',
    short: 'Transparansi APBD, realisasi anggaran, dan aset daerah.',
    icon: 'keuangan',
    about: 'BPKAD mempublikasikan realisasi APBD, laporan keuangan, dan data aset daerah secara berkala sebagai bentuk akuntabilitas dan transparansi pengelolaan keuangan Kota Magelang.',
    stats: [ ['4', 'Triwulan laporan/tahun'], ['100%', 'Opini WTP terakhir'], ['1.2rb+', 'Item aset tercatat'], ['Terbuka', 'Akses publik'] ],
    datasets: [
      { name: 'Realisasi APBD Triwulan II 2026', meta: 'XLSX · Diperbarui 1 Agu 2026' },
      { name: 'Laporan Keuangan Daerah 2025 (Audited)', meta: 'PDF · Diperbarui 12 Mei 2026' },
      { name: 'Daftar Aset Tetap Pemerintah Kota', meta: 'CSV · Diperbarui 10 Jul 2026' }
    ]
  },
  kepegawaian: {
    name: 'Kepegawaian',
    office: 'Badan Kepegawaian dan Pengembangan SDM',
    short: 'Data ASN, formasi jabatan, dan pengembangan kompetensi pegawai.',
    icon: 'kepegawaian',
    about: 'BKPSDM mengelola data kepegawaian ASN Kota Magelang, formasi jabatan, mutasi, serta program pengembangan kompetensi aparatur sipil negara.',
    stats: [ ['3.400+', 'ASN aktif'], ['62', 'Formasi CASN 2026'], ['48', 'Pelatihan/tahun'], ['27', 'OPD terdata'] ],
    datasets: [
      { name: 'Formasi CASN & PPPK 2026', meta: 'PDF · Diperbarui 22 Jul 2026' },
      { name: 'Rekap Jumlah ASN per OPD', meta: 'XLSX · Diperbarui 18 Jul 2026' },
      { name: 'Jadwal Diklat & Pengembangan SDM', meta: 'PDF · Diperbarui 3 Jul 2026' }
    ]
  },
  kependudukan: {
    name: 'Kependudukan',
    office: 'Dinas Kependudukan dan Pencatatan Sipil',
    short: 'Layanan KTP, KK, akta, dan statistik kependudukan.',
    icon: 'kependudukan',
    about: 'Disdukcapil menyediakan layanan administrasi kependudukan — KTP-el, Kartu Keluarga, akta kelahiran dan kematian — serta data agregat kependudukan Kota Magelang.',
    stats: [ ['121rb+', 'Penduduk terdaftar'], ['99.1%', 'Perekaman KTP-el'], ['5', 'Kecamatan'], ['37', 'Kelurahan'] ],
    datasets: [
      { name: 'Jumlah Penduduk per Kelurahan 2026', meta: 'XLSX · Diperbarui 25 Jul 2026' },
      { name: 'Statistik Kelahiran & Kematian', meta: 'CSV · Diperbarui 15 Jul 2026' },
      { name: 'Panduan Layanan Adminduk Daring', meta: 'PDF · Diperbarui 1 Jun 2026' }
    ]
  },
  pembangunan: {
    name: 'Pembangunan',
    office: 'Dinas Pekerjaan Umum dan Penataan Ruang',
    short: 'Data infrastruktur, tata ruang, dan proyek pembangunan kota.',
    icon: 'pembangunan',
    about: 'DPUPR mengawal pembangunan infrastruktur jalan, drainase, dan penataan ruang Kota Magelang, serta mempublikasikan progres proyek strategis daerah.',
    stats: [ ['86 km', 'Panjang jalan kota'], ['14', 'Proyek berjalan'], ['92%', 'Jalan kondisi baik'], ['1', 'RTRW aktif'] ],
    datasets: [
      { name: 'Progres Proyek Infrastruktur 2026', meta: 'PDF · Diperbarui 4 Agu 2026' },
      { name: 'Peta Rencana Tata Ruang Wilayah', meta: 'PDF · Diperbarui 10 Mar 2026' },
      { name: 'Data Kondisi Jalan per Ruas', meta: 'XLSX · Diperbarui 29 Jul 2026' }
    ]
  },
  perhubungan: {
    name: 'Perhubungan',
    office: 'Dinas Perhubungan',
    short: 'Data lalu lintas, angkutan umum, dan titik parkir kota.',
    icon: 'perhubungan',
    about: 'Dinas Perhubungan mengelola manajemen lalu lintas, trayek angkutan umum, dan fasilitas perparkiran, termasuk pemantauan titik rawan kemacetan di Kota Magelang.',
    stats: [ ['9', 'Trayek angkutan kota'], ['24', 'Titik parkir resmi'], ['6', 'Simpang ber-ATCS'], ['3.2rb', 'Kendaraan/hari terpantau'] ],
    datasets: [
      { name: 'Peta Trayek Angkutan Umum', meta: 'PDF · Diperbarui 8 Jul 2026' },
      { name: 'Data Titik Parkir & Kapasitas', meta: 'CSV · Diperbarui 2 Agu 2026' },
      { name: 'Laporan Volume Lalu Lintas', meta: 'XLSX · Diperbarui 27 Jul 2026' }
    ]
  },
  sig: {
    name: 'SIG',
    office: 'Sistem Informasi Geografis',
    short: 'Peta digital dan data spasial terpadu Kota Magelang.',
    icon: 'sig',
    about: 'Layanan SIG menyediakan basis data spasial terpadu — batas administrasi, tata guna lahan, dan lapisan infrastruktur — untuk mendukung perencanaan lintas dinas.',
    stats: [ ['18', 'Lapisan data spasial'], ['1:5.000', 'Skala peta dasar'], ['37', 'Kelurahan terpetakan'], ['2026', 'Pemutakhiran terakhir'] ],
    datasets: [
      { name: 'Peta Batas Administrasi Kelurahan', meta: 'GeoJSON · Diperbarui 20 Jul 2026' },
      { name: 'Peta Tata Guna Lahan', meta: 'PDF · Diperbarui 5 Jun 2026' },
      { name: 'Basis Data Infrastruktur Kota', meta: 'SHP · Diperbarui 30 Jun 2026' }
    ]
  }
};

// ---------- CCTV dataset ----------
// GANTI GAMBAR PER LOKASI DI SINI: Ubah property 'image' dengan path gambar yang sesuai untuk setiap CCTV
const CCTV_POINTS = [
 { id: 'taman-badaan-barat', name: 'Taman Badaan Barat', area: 'Kecamatan Magelang Tengah', status: 'online', image: '/images/cctv_park.jpg' },
  { id: 'taman-skateboard-magersari', name: 'Taman Skateboard Magersari', area: 'Kecamatan Magelang Selatan', status: 'online', image: '/images/tamanskateboard.png' },
  { id: 'taman-depan-atria', name: 'Taman Depan Atria', area: 'Kecamatan Magelang Tengah', status: 'online', image: '/images/tamandepanatrian.png' },
  { id: 'batas-utara', name: 'Batas Utara Kota Magelang', area: 'Kecamatan Magelang Utara', status: 'online', image: '/images/batasUtarakota_magelang.png' },
  { id: 'kebun-bibit-senopati', name: 'Kebun Bibit Senopati', area: 'Kecamatan Magelang Utara', status: 'online', image: '/images/bibit_senopati.png' },
  { id: 'pertigaan-sman1', name: 'Pertigaan SMA Negeri 1', area: 'Kecamatan Magelang Tengah', status: 'online', image: '/images/sman1kota.png' },
  { id: 'alun-alun', name: 'Alun-Alun Kota Magelang', area: 'Kecamatan Magelang Tengah', status: 'online', image: '/images/alunalun_magelang.png' },
  { id: 'pasar-rejowinangun', name: 'Pasar Rejowinangun', area: 'Kecamatan Magelang Selatan', status: 'online', image: '/images/pasar_rejowinangun.png' }
];

function cctvCardHTML(cam) {
  const isOnline = cam.status === 'online';
  // Gambar ditarik dari property 'image' pada data CCTV
  const placeholderImage = cam.image || '/images/cctv_park.jpg';
  
  return `
  <article class="cctv-card">
    <div class="cctv-thumb">
      <img src="${placeholderImage}" alt="${cam.name}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:0;" />
      <div class="feed" style="z-index:1; background: repeating-linear-gradient(0deg, rgba(0,0,0,.08) 0 2px, transparent 2px 4px);"></div>
      <button class="cctv-play-button" type="button" aria-label="Putar live ${cam.name}" onclick="window.showCctvLive('${cam.id}')">
        <svg viewBox="0 0 24 24" aria-hidden="true"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
      </button>
      <div class="cam-icon" style="z-index:2; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">${ICONS.camera}</div>
      <span class="live-tag" style="z-index:2;">${isOnline ? 'LIVE' : 'OFFLINE'}</span>
    </div>
    <div class="cctv-body">
      <div class="cctv-top">
        <h3>${cam.name}</h3>
        <span class="status-pill ${isOnline ? 'online' : 'offline'}"><span class="dot"></span>${isOnline ? 'Online' : 'Offline'}</span>
      </div>
      <a class="btn btn-outline" href="#" style="width:100%" data-cam="${cam.id}" onclick="if(window.showCctvLive) { window.showCctvLive('${cam.id}'); } else { window.location.href = '/cctv?cam=' + '${cam.id}'; } return false;">Lihat Live</a>
    </div>
  </article>`;
}

// Render CCTV grid on the homepage (first 6) and the "all" page (all points)
function renderCctvGrid(targetSelector, limit) {
  const el = document.querySelector(targetSelector);
  if (!el) return;
  const points = limit ? CCTV_POINTS.slice(0, limit) : CCTV_POINTS;
  el.innerHTML = points.map(cctvCardHTML).join('');
}

window.showCctvLive = function(camId) {
  const cam = CCTV_POINTS.find(c => c.id === camId);
  if (!cam) return;
  
  const isOnline = cam.status === 'online';
  
  // Hide grid and hero
  const gridContainer = document.querySelector('[data-cctv-grid]');
  if(gridContainer) gridContainer.style.display = 'none';
  
  const heroSection = document.querySelector('.page-hero');
  if(heroSection) heroSection.style.display = 'none';
  
  // Create or get live view container
  let liveView = document.getElementById('cctv-live-view');
  if (!liveView) {
    liveView = document.createElement('div');
    liveView.id = 'cctv-live-view';
    const wrap = gridContainer ? gridContainer.closest('.wrap') : null;
    if (wrap) wrap.appendChild(liveView);
  }
  
  liveView.style.display = 'block';
  
  // Gambar ditarik dari property 'image' pada data CCTV
  const placeholderImage = cam.image || '/images/cctv_park.jpg';
  
  liveView.innerHTML = `
    <div class="cctv-live-container">
      <a href="#" onclick="window.showCctvGrid(); return false;" class="back-link">
        &larr; Kembali ke Semua CCTV Publik
      </a>
      
      <div class="cctv-live-player">
        <img src="${placeholderImage}" alt="${cam.name}" class="cctv-live-image" />
        <div class="play-icon-overlay">
          <svg viewBox="0 0 24 24" fill="white" stroke="none"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
        </div>
      </div>
      
      <div class="cctv-live-info">
        <div>
          <h2 class="cctv-live-title">${cam.name}</h2>
          <p class="cctv-live-meta">${cam.area} &middot; Monitoring CCTV publik Kota Magelang</p>
        </div>
        <span class="status-pill ${isOnline ? 'online' : 'offline'}">
          <span class="dot"></span>${isOnline ? 'Online' : 'Offline'}
        </span>
      </div>
    </div>
  `;
  
  // Smooth scroll to the live view, accounting for fixed header height (approx 70px)
  setTimeout(() => {
    const headerHeight = document.querySelector('.site-header') ? document.querySelector('.site-header').offsetHeight : 70;
    const y = liveView.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
    window.scrollTo({ top: y, behavior: 'smooth' });
  }, 50);
};

window.showCctvGrid = function() {
  const gridContainer = document.querySelector('[data-cctv-grid]');
  if(gridContainer) gridContainer.style.display = '';
  
  const heroSection = document.querySelector('.page-hero');
  if(heroSection) heroSection.style.display = ''; 
  
  const liveView = document.getElementById('cctv-live-view');
  if (liveView) liveView.style.display = 'none';
  
  // Smooth scroll to top when going back
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Render department detail page based on ?dept= query param
function renderDeptPage() {
  const root = document.querySelector('[data-dept-page]');
  if (!root) return;
  const params = new URLSearchParams(window.location.search);
  const slug = params.get('dept') || 'perizinan';
  const dept = DEPARTMENTS[slug] || DEPARTMENTS.perizinan;

  document.title = `${dept.name} — Command Center Kota Magelang`;

  document.querySelector('[data-dept-icon]').innerHTML = ICONS[dept.icon];
  document.querySelector('[data-dept-name]').textContent = dept.name;
  document.querySelector('[data-dept-office]').textContent = dept.office;
  document.querySelector('[data-dept-about]').textContent = dept.about;

  document.querySelector('[data-dept-stats]').innerHTML = dept.stats.map(([num, lbl]) => `
    <div class="stat-card"><div class="num">${num}</div><div class="lbl">${lbl}</div></div>
  `).join('');

  document.querySelector('[data-dept-datasets]').innerHTML = dept.datasets.map(d => `
    <li>
      <div>
        <div class="file-name">${d.name}</div>
        <div class="file-meta">${d.meta}</div>
      </div>
      <a class="dl" href="#" onclick="alert('Demo: unduhan berkas akan dimulai di sini.'); return false;">${ICONS.file} Unduh</a>
    </li>
  `).join('');

  // quick-switch chips to browse other departments
  const nav = document.querySelector('[data-dept-nav]');
  if (nav) {
    nav.innerHTML = Object.keys(DEPARTMENTS).map(key => `
      <a href="layanan.html?dept=${key}" class="${key === slug ? 'active' : ''}">${DEPARTMENTS[key].name}</a>
    `).join('');
  }
}

// Render service cards on homepage
function renderServiceCards(targetSelector) {
  const el = document.querySelector(targetSelector);
  if (!el) return;
  el.innerHTML = Object.keys(DEPARTMENTS).map(key => {
    const d = DEPARTMENTS[key];
    return `
    <article class="svc-card">
      <div class="svc-icon">${ICONS[d.icon]}</div>
      <h3>${d.name}</h3>
      <p>${d.office}</p>
      <a class="btn btn-outline" href="layanan.html?dept=${key}">Lihat Data Publik</a>
    </article>`;
  }).join('');
}

// ---------- Login demo form ----------
function bindLoginForm() {
  const form = document.querySelector('#login-form');
  if (!form) return;
  // Let the form submit natively to Laravel backend
}

document.addEventListener('DOMContentLoaded', () => {
  renderServiceCards('[data-service-grid]');
  renderCctvGrid('[data-cctv-grid]', document.body.dataset.cctvLimit ? Number(document.body.dataset.cctvLimit) : null);
  renderDeptPage();
  bindLoginForm();
});

