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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Call Admin Seeder
        $this->call([
            AdminSeeder::class,
        ]);

        // 2. Add Missing Divisions
        $divPerhubungan = Division::firstOrCreate(['name' => 'Perhubungan']);
        $divSig = Division::firstOrCreate(['name' => 'SIG']);
        $divPembangunan = Division::firstOrCreate(['name' => 'Pembangunan']);

        // 3. Add Users for Perhubungan, SIG, and Pembangunan
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

        // 4. Seed PembangunanProject (10 Data)
        // Fillable: 'project_code', 'name', 'category', 'kecamatan', 'kelurahan', 'total_budget', 'realized_budget', 'progress_percentage', 'status', 'latitude', 'longitude'
        $statuses = ['Berjalan', 'Selesai', 'Tertunda'];
        $categories = ['Infrastruktur', 'Gedung', 'Fasilitas Publik'];
        for ($i = 1; $i <= 10; $i++) {
            PembangunanProject::create([
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
        }

        // 5. Seed UjiKIR (10 Data)
        // Fillable: 'tanggal_uji', 'jenis_kendaraan', 'status_uji', 'unit_layanan', 'keterangan'
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

        // 6. Seed LayerSIG (minimal 3 layer)
        // Fillable: 'nama_layer', 'status_aktif'
        $layers = [
            LayerSig::create(['nama_layer' => 'Batas Administrasi', 'status_aktif' => true]),
            LayerSig::create(['nama_layer' => 'Jaringan Jalan', 'status_aktif' => true]),
            LayerSig::create(['nama_layer' => 'Fasilitas Umum', 'status_aktif' => true]),
        ];

        // 7. Seed DataSpasial (10 Data)
        // Fillable: 'layer_id', 'nama_data', 'kategori', 'wilayah', 'nilai_jumlah', 'latitude', 'longitude'
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
    }
}
