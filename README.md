# Command Center Kota Magelang

Platform pusat kendali dan data terintegrasi milik Pemerintah Kota Magelang untuk mendukung pemantauan, analisis, dan pelayanan publik yang transparan.

---

## Panduan Instalasi & Menjalankan Proyek (Local Development)

Ikuti langkah-langkah berikut ketika baru pertama kali meng-clone repository ini:

### 1. Clone Repository
```bash
git clone https://github.com/arccoputraa/commandcentermgl.git
cd commandcentermgl
```

### 2. Install Dependencies
```bash
# Install dependensi backend (PHP)
composer install

# Install dependensi frontend (Node.js)
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env` lalu buat application key:
```bash
# Di Windows (CMD / PowerShell):
copy .env.example .env

# Di Linux / macOS / Git Bash:
cp .env.example .env

# Generate Application Key
php artisan key:generate
```

### 4. Setup Database & Seeding
Proyek ini secara default menggunakan **SQLite**. Pastikan file database sudah dibuat:

```bash
# Di PowerShell:
New-Item -ItemType File database\database.sqlite -Force

# Di Git Bash / Linux / macOS:
touch database/database.sqlite
```

Jalankan migrasi tabel dan seeding data dummy awal:
```bash
php artisan migrate:fresh --seed
```

### 5. Build Aset Frontend (Vite)
Compile aset CSS dan JS:
```bash
npm run build
```
*Atau jalankan `npm run dev` jika sedang dalam proses pengembangan/editing.*

### 6. Jalankan Web Server
```bash
php artisan serve
```
Akses aplikasi melalui browser di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Akun Login Default (Super Admin & Admin Divisi)

Setelah menjalankan `php artisan migrate:fresh --seed`, seluruh akun berikut otomatis dibuat dengan **password default:** `password`

### 1. Super Administrator (Dashboard Utama)
- **Email:** `admin@magelangkota.go.id`
- **Password:** `password`
*(Akan diarahkan ke `/admin`)*

### 2. Admin Per Divisi
Setiap akun admin divisi otomatis langsung diarahkan ke dashboard internal divisinya masing-masing saat login:

| Divisi | Email Login | Password | Dashboard Tujuan |
|---|---|---|---|
| **Perizinan** | `admin_perizinan@magelangkota.go.id` | `password` | `/perizinan` |
| **Kesehatan** | `admin_kesehatan@magelangkota.go.id` | `password` | `/kesehatan` |
| **Keuangan** | `admin_keuangan@magelangkota.go.id` | `password` | `/keuangan` |
| **Kepegawaian** | `admin_kepegawaian@magelangkota.go.id` | `password` | `/kepegawaian` |
| **Pembangunan** | `admin_pembangunan@magelangkota.go.id` | `password` | `/pembangunan` |
| **Kependudukan** | `admin_kependudukan@magelangkota.go.id` | `password` | `/kependudukan` |
| **Perhubungan** | `admin_perhubungan@magelangkota.go.id` | `password` | `/admin/perhubungan` |
| **SIG** | `admin_sig@magelangkota.go.id` | `password` | `/admin/sig` |

---

## Catatan Penting
- **PHP Version:** Memerlukan PHP versi **>= 8.2** (disarankan PHP 8.3).
- **HTTPS vs HTTP:** Konfigurasi `forceScheme('https')` pada `AppServiceProvider` hanya aktif saat `APP_ENV=production`. Untuk local development, aplikasi berjalan menggunakan protokol HTTP standar.
