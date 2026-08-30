<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Division;
use App\Models\UjiKir;
use App\Models\DataSpasial;
use App\Models\LayerSig;
use App\Models\PembangunanProject;
use App\Models\PembangunanDocument;
use App\Models\PerizinanJenis;
use App\Models\PerizinanData;
use App\Models\PerizinanPublikasi;
use App\Models\PegawaiData;
use App\Models\PegawaiMutasi;
use App\Models\PegawaiInformasi;
use App\Models\FinanceBudget;
use App\Models\FinancePad;
use App\Models\FinanceTax;
use App\Models\FinanceInformation;
use App\Models\KesehatanInformasi;
use App\Models\KesehatanPenyakit;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
        ]);

        $divPerhubungan = Division::firstOrCreate(['name' => 'Perhubungan']);
        $divSig = Division::firstOrCreate(['name' => 'SIG']);
        $divPembangunan = Division::firstOrCreate(['name' => 'Pembangunan']);
        $divKepegawaian = Division::firstOrCreate(['name' => 'Kepegawaian']);

        User::firstOrCreate(
            ['email' => 'admin_perhubungan@magelangkota.go.id'],
            [
                'name' => 'Admin Perhubungan',
                'password' => 'password',
                'nip' => '198001012005011002',
                'role' => 'admin',
                'status' => 'aktif',
                'division_id' => $divPerhubungan->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin_sig@magelangkota.go.id'],
            [
                'name' => 'Admin SIG',
                'password' => 'password',
                'nip' => '198001012005011003',
                'role' => 'admin',
                'status' => 'aktif',
                'division_id' => $divSig->id,
            ]
        );
        
        User::firstOrCreate(
            ['email' => 'admin_pembangunan@magelangkota.go.id'],
            [
                'name' => 'Admin Pembangunan',
                'password' => 'password',
                'nip' => '198001012005011004',
                'role' => 'admin',
                'status' => 'aktif',
                'division_id' => $divPembangunan->id,
            ]
        );
        
        $divPerizinan = Division::firstOrCreate(['name' => 'Perizinan']);
        $divKesehatan = Division::firstOrCreate(['name' => 'Kesehatan']);
        $divKeuangan = Division::firstOrCreate(['name' => 'Keuangan']);
        
        User::firstOrCreate(
            ['email' => 'admin_kepegawaian@magelangkota.go.id'],
            ['name' => 'Admin Kepegawaian', 'password' => 'password', 'nip' => '198001012005011006', 'role' => 'admin', 'status' => 'aktif', 'division_id' => $divKepegawaian->id]
        );
        User::firstOrCreate(
            ['email' => 'admin_perizinan@magelangkota.go.id'],
            ['name' => 'Admin Perizinan', 'password' => 'password', 'nip' => '198001012005011007', 'role' => 'admin', 'status' => 'aktif', 'division_id' => $divPerizinan->id]
        );
        User::firstOrCreate(
            ['email' => 'admin_kesehatan@magelangkota.go.id'],
            ['name' => 'Admin Kesehatan', 'password' => 'password', 'nip' => '198001012005011008', 'role' => 'admin', 'status' => 'aktif', 'division_id' => $divKesehatan->id]
        );
        User::firstOrCreate(
            ['email' => 'admin_keuangan@magelangkota.go.id'],
            ['name' => 'Admin Keuangan', 'password' => 'password', 'nip' => '198001012005011009', 'role' => 'admin', 'status' => 'aktif', 'division_id' => $divKeuangan->id]
        );

        // 1. Pembangunan
        $statuses = ['Berjalan', 'Selesai', 'Tertunda'];
        $categories = ['Infrastruktur', 'Gedung', 'Fasilitas Publik'];
        for ($i = 1; $i <= 10; $i++) {
            $prj = PembangunanProject::create([
                'project_code' => 'PRJ-' . date('Y') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Proyek Pembangunan ' . $i . ' Kota Magelang',
                'category' => $categories[array_rand($categories)],
                'kecamatan' => ['Magelang Utara', 'Magelang Tengah', 'Magelang Selatan'][rand(0, 2)],
                'kelurahan' => 'Kelurahan ' . $i,
                'total_budget' => rand(100, 1000) * 1000000,
                'realized_budget' => rand(50, 500) * 1000000,
                'progress_percentage' => rand(10, 100),
                'status' => $statuses[array_rand($statuses)],
                'latitude' => '-7.' . rand(450000, 480000),
                'longitude' => '110.' . rand(210000, 240000),
            ]);
            PembangunanDocument::create([
                'pembangunan_project_id' => $prj->id,
                'title' => 'Dokumentasi ' . $prj->name,
                'type' => 'Image',
                'file_path' => 'dummy/path/to/image.jpg',
                'upload_date' => Carbon::now()->subDays(rand(1, 10)),
                'status_tag' => 'Rilis',
                'description' => 'Foto dokumentasi proyek',
            ]);
        }

        // 2. Perhubungan
        $jenisKendaraan = ['Mobil Penumpang', 'Bus', 'Truk', 'Kendaraan Khusus'];
        $statusUji = ['Lulus Uji', 'Tidak Lulus', 'Perlu Uji Ulang'];
        $unitLayanan = ['UPT KIR Magelang', 'Pos Pembantu'];
        for ($i = 1; $i <= 10; $i++) {
            UjiKir::create([
                'tanggal_uji' => Carbon::now()->subDays(rand(1, 30)),
                'jenis_kendaraan' => $jenisKendaraan[array_rand($jenisKendaraan)],
                'status_uji' => $statusUji[array_rand($statusUji)],
                'unit_layanan' => $unitLayanan[array_rand($unitLayanan)],
                'keterangan' => 'Uji KIR otomatis ke-' . $i,
            ]);
        }

        // 3. SIG
        $layers = [
            LayerSig::create(['nama_layer' => 'Batas Administrasi', 'status_aktif' => true]),
            LayerSig::create(['nama_layer' => 'Jaringan Jalan', 'status_aktif' => true]),
            LayerSig::create(['nama_layer' => 'Fasilitas Umum', 'status_aktif' => true]),
        ];

        for ($i = 1; $i <= 10; $i++) {
            $layer = $layers[array_rand($layers)];
            DataSpasial::create([
                'layer_id' => $layer->id,
                'nama_data' => 'Data Spasial ' . $i,
                'kategori' => 'Kategori ' . rand(1, 5),
                'wilayah' => 'Kecamatan ' . ['Magelang Utara', 'Magelang Tengah', 'Magelang Selatan'][rand(0, 2)],
                'nilai_jumlah' => rand(10, 100),
                'latitude' => '-7.' . rand(450000, 480000),
                'longitude' => '110.' . rand(210000, 240000),
            ]);
        }

        // 4. Perizinan
        $jenis = PerizinanJenis::create(['jenis_izin' => 'Izin Mendirikan Bangunan (IMB)', 'kategori' => 'Pembangunan', 'sla' => 14, 'status' => 'Aktif']);
        $statusPerizinan = ['Disetujui', 'Proses', 'Ditolak'];
        for ($i = 1; $i <= 15; $i++) {
            PerizinanData::create([
                'no_dokumen' => 'IZIN-' . date('Y') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama_pemohon' => 'Pemohon ' . $i,
                'perizinan_jenis_id' => $jenis->id,
                'jenis_permohonan' => ['Baru', 'Perpanjangan'][rand(0, 1)],
                'tanggal' => Carbon::now()->subMonths(rand(0, 6)),
                'status' => $statusPerizinan[array_rand($statusPerizinan)],
                'lokasi_kecamatan' => ['Magelang Utara', 'Magelang Tengah', 'Magelang Selatan'][rand(0, 2)],
            ]);
        }
        PerizinanPublikasi::create(['judul' => 'SOP Perizinan 2026', 'kategori' => 'Regulasi', 'status' => 'Aktif', 'format' => 'PDF']);

        // 5. Kepegawaian
        for ($i = 1; $i <= 20; $i++) {
            PegawaiData::create([
                'nip' => '19800101' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama' => 'Pegawai ' . $i,
                'jenis_pegawai' => ['PNS', 'PPPK', 'Non-ASN'][rand(0, 2)],
                'jenis_kelamin' => ['Laki-laki', 'Perempuan'][rand(0, 1)],
                'jabatan' => 'Staf Pelaksana',
                'golongan' => ['III/a', 'III/b', 'IV/a', 'II/c'][rand(0, 3)],
                'unit_kerja' => ['Dinas Pendidikan', 'Dinas Kesehatan', 'Dinas Perhubungan'][rand(0, 2)],
                'status_pegawai' => 'Aktif',
                'tanggal_bergabung' => Carbon::now()->subYears(rand(1, 10)),
            ]);
        }
        PegawaiMutasi::create(['nip' => '198001010001', 'nama_pegawai' => 'Pegawai 1', 'jenis' => 'Promosi', 'tanggal_efektif' => Carbon::now(), 'status_pengajuan' => 'Selesai']);
        PegawaiInformasi::create(['judul' => 'Pengumuman Libur Nasional', 'kategori' => 'Umum', 'status_publikasi' => 'Rilis']);

        // 6. Keuangan
        for ($i = 1; $i <= 5; $i++) {
            FinanceBudget::create([
                'tahun' => 2026,
                'sub_bidang' => ['Pendidikan', 'Kesehatan', 'Infrastruktur', 'Sosial', 'Ekonomi'][$i-1],
                'nama_anggaran' => 'Anggaran Bidang ' . $i,
                'total_anggaran' => rand(1000, 5000) * 1000000,
                'total_realisasi' => rand(500, 4000) * 1000000,
                'status' => 'Aktif'
            ]);
        }
        FinancePad::create(['tahun' => 2026, 'sumber_pendapatan' => 'Pajak Daerah', 'target_pad' => 5000000000, 'realisasi_pad' => 3000000000, 'status' => 'Aktif']);
        FinanceTax::create(['tahun' => 2026, 'jenis_pajak' => 'Pajak Hotel', 'jumlah_wajib_pajak' => 120, 'jumlah_pendapatan' => 1500000000, 'status' => 'Aktif']);
        FinanceInformation::create(['judul' => 'Laporan Realisasi APBD Semester 1', 'kategori' => 'Laporan', 'status_publikasi' => 'Rilis']);

        // 7. Kesehatan
        for ($i = 1; $i <= 5; $i++) {
            KesehatanPenyakit::create([
                'nama' => ['DBD', 'ISPA', 'Diare', 'Tipes', 'Hipertensi'][$i-1],
                'jumlah' => rand(50, 500),
                'tahun' => 2026,
                'bulan' => rand(1, 6),
                'wilayah' => ['Magelang Utara', 'Magelang Tengah', 'Magelang Selatan'][rand(0, 2)],
                'status' => 'Aktif'
            ]);
        }
        KesehatanInformasi::create(['judul' => 'Jadwal Imunisasi Balita', 'file_pdf' => 'jadwal.pdf']);

        // 8. Kependudukan
        $divKependudukan = Division::firstOrCreate(['name' => 'Kependudukan']);
        User::firstOrCreate(
            ['email' => 'admin_kependudukan@magelangkota.go.id'],
            [
                'name' => 'Admin Kependudukan',
                'password' => 'password',
                'nip' => '198001012005011005',
                'role' => 'admin',
                'status' => 'aktif',
                'division_id' => $divKependudukan->id,
            ]
        );
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\KependudukanPenduduk::create([
                'tahun' => 2026,
                'kecamatan' => ['Magelang Utara', 'Magelang Tengah', 'Magelang Selatan'][rand(0, 2)],
                'kelurahan' => 'Kelurahan ' . $i,
                'penduduk' => rand(5000, 10000),
                'laki_laki' => rand(2000, 5000),
                'perempuan' => rand(2000, 5000),
                'wajib_ktp' => rand(3000, 7000),
                'usia_produktif' => rand(2000, 6000),
                'anak' => rand(500, 2000),
                'lansia' => rand(500, 1500),
                'kk' => rand(1000, 3000),
                'agama' => 'Islam',
                'status' => 'Aktif',
            ]);
        }
        for ($i = 1; $i <= 3; $i++) {
            \App\Models\KependudukanMutasi::create([
                'tahun' => 2026,
                'bulan' => ['Januari', 'Februari', 'Maret'][$i-1],
                'kecamatan' => 'Magelang Tengah',
                'kelurahan' => 'Kelurahan 1',
                'kelahiran' => rand(5, 20),
                'kematian' => rand(2, 10),
                'pindah_datang' => rand(10, 30),
                'pindah_keluar' => rand(5, 15),
                'status' => 'Aktif',
            ]);
            \App\Models\KependudukanInformasi::create([
                'judul' => 'Informasi Kependudukan ' . $i,
                'kategori' => 'Umum',
                'file' => 'info.pdf',
                'tanggal' => Carbon::now()->subDays($i),
                'status' => 'Rilis',
            ]);
        }
    }
}
