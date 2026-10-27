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

Untuk lingkungan lokal, jalankan migrasi dan seeding data contoh:

```bash
php artisan migrate:fresh --seed
```

`migrate:fresh` menghapus seluruh tabel dan data. Perintah ini hanya untuk database lokal yang boleh direset; jangan jalankan pada database staging atau produksi. Seeder proyek membuat data contoh dan akun pengujian dengan kredensial bawaan, sehingga hasil seeding tidak boleh digunakan atau diekspos pada deployment.

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

## Akun Pengujian Lokal

Seeder lokal membuat akun administrator dan admin divisi untuk pengujian. Kredensial bawaan hanya boleh digunakan pada mesin lokal; detailnya ada di seeder proyek. Akun tersebut bukan akun operasional dan seeder yang membuat akun bawaan ditolak pada `APP_ENV=production`.

---

## Catatan Penting
- **PHP Version:** Memerlukan PHP versi **>= 8.5**.
- **HTTPS vs HTTP:** Konfigurasi `forceScheme('https')` pada `AppServiceProvider` hanya aktif saat `APP_ENV=production`. Untuk local development, aplikasi berjalan menggunakan protokol HTTP standar.
- **Deployment:** Sebelum deployment, siapkan database produksi, `.env`, kredensial administrator baru, penyimpanan dokumen, serta proses backup dan migrasi yang disetujui pengelola sistem. Jangan memakai data contoh dari seeder sebagai data resmi.
