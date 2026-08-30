<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Setup Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        // 1. MODULE PEMBANGUNAN
        $this->command->info('Seeding Pembangunan...');
        DB::table('pembangunan_project_progresses')->delete();
        DB::table('pembangunan_projects')->delete();
        
        $kategoriPembangunan = ['Jalan', 'Drainase', 'Gedung', 'Fasilitas Umum', 'Taman'];
        $statusPembangunan = ['Selesai', 'Berjalan', 'Tertunda'];
        $kecamatan = ['Magelang Selatan', 'Magelang Tengah', 'Magelang Utara'];

        for ($i = 0; $i < 30; $i++) {
            $total_budget = $faker->numberBetween(5, 50) * 100000000; // 500M - 5Miliar
            $stat = $faker->randomElement($statusPembangunan);
            
            if ($stat == 'Selesai') {
                $realized_budget = $total_budget;
                $progress_percentage = 100;
            } elseif ($stat == 'Tertunda') {
                $realized_budget = $total_budget * ($faker->numberBetween(10, 40) / 100);
                $progress_percentage = round(($realized_budget / $total_budget) * 100);
            } else {
                $realized_budget = $total_budget * ($faker->numberBetween(20, 90) / 100);
                $progress_percentage = round(($realized_budget / $total_budget) * 100);
            }

            // Magelang Coords: Lat: -7.50 to -7.45, Lng: 110.20 to 110.24
            $lat = $faker->randomFloat(6, -7.50, -7.45);
            $lng = $faker->randomFloat(6, 110.20, 110.24);

            $project_id = DB::table('pembangunan_projects')->insertGetId([
                'project_code' => 'PRJ-' . Carbon::now()->format('Y') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'name' => 'Pembangunan ' . $faker->randomElement($kategoriPembangunan) . ' ' . $faker->streetName,
                'category' => $faker->randomElement($kategoriPembangunan),
                'kecamatan' => $faker->randomElement($kecamatan),
                'kelurahan' => $faker->citySuffix,
                'total_budget' => $total_budget,
                'realized_budget' => $realized_budget,
                'progress_percentage' => $progress_percentage,
                'status' => $stat,
                'latitude' => $lat,
                'longitude' => $lng,
                'created_at' => Carbon::now()->subDays(rand(1, 100)),
                'updated_at' => Carbon::now(),
            ]);

            // Add progress
            DB::table('pembangunan_project_progresses')->insert([
                'project_id' => $project_id,
                'report_date' => Carbon::now()->subDays(rand(1, 10)),
                'progress_percentage' => $progress_percentage,
                'realized_budget' => $realized_budget,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 2. MODULE PERHUBUNGAN
        $this->command->info('Seeding Perhubungan...');
        DB::table('uji_kir')->delete();
        
        $statusKir = ['Lulus Uji', 'Tidak Lulus', 'Perlu Uji Ulang'];
        $jenisKendaraan = ['Truk', 'Pickup', 'Bus', 'Minibus', 'Taksi'];
        $unitLayanan = ['Unit A', 'Unit B', 'Unit C'];

        for ($i = 0; $i < 30; $i++) {
            DB::table('uji_kir')->insert([
                'tanggal_uji' => Carbon::now()->subDays(rand(1, 30)),
                'jenis_kendaraan' => $faker->randomElement($jenisKendaraan),
                'status_uji' => $faker->randomElement($statusKir),
                'unit_layanan' => $faker->randomElement($unitLayanan),
                'keterangan' => $faker->sentence,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 3. MODULE SIG
        $this->command->info('Seeding SIG...');
        DB::table('data_spasial')->delete();
        DB::table('layer_sig')->delete();

        $layers = ['Layer Jalan', 'Layer Rumah Sakit', 'Layer Sekolah', 'Layer Perkantoran', 'Layer Taman'];
        $layerIds = [];
        foreach ($layers as $layer) {
            $layerIds[] = DB::table('layer_sig')->insertGetId([
                'nama_layer' => $layer,
                'status_aktif' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 0; $i < 25; $i++) {
            DB::table('data_spasial')->insert([
                'layer_id' => $faker->randomElement($layerIds),
                'nama_data' => 'Titik ' . $faker->company,
                'kategori' => 'Fasilitas',
                'wilayah' => $faker->randomElement($kecamatan),
                'nilai_jumlah' => $faker->numberBetween(1, 100),
                'latitude' => $faker->randomFloat(6, -7.50, -7.45),
                'longitude' => $faker->randomFloat(6, 110.20, 110.24),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 4. MODULE KEUANGAN
        $this->command->info('Seeding Keuangan...');
        DB::table('finance_budgets')->delete();
        DB::table('finance_pads')->delete();
        DB::table('finance_taxes')->delete();

        $subBidang = ['Bidang Pendidikan', 'Bidang Kesehatan', 'Bidang Infrastruktur', 'Bidang Sosial'];
        for ($i = 0; $i < 20; $i++) {
            $anggaran = $faker->numberBetween(100, 500) * 10000000;
            $realisasi = $anggaran * ($faker->numberBetween(40, 95) / 100);
            DB::table('finance_budgets')->insert([
                'tahun' => 2026,
                'sub_bidang' => $faker->randomElement($subBidang),
                'nama_anggaran' => 'Anggaran ' . $faker->company,
                'total_anggaran' => $anggaran,
                'total_realisasi' => $realisasi,
                'periode' => $faker->randomElement(['Q1', 'Q2', 'Q3', 'Q4']),
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $sumberPad = ['Pajak Daerah', 'Retribusi Daerah', 'Hasil Pengelolaan Kekayaan', 'Lain-lain PAD yang Sah'];
        for ($i = 0; $i < 20; $i++) {
            $target = $faker->numberBetween(50, 200) * 10000000;
            $realisasiPad = $target * ($faker->numberBetween(30, 110) / 100); 
            DB::table('finance_pads')->insert([
                'tahun' => 2026,
                'sumber_pendapatan' => $faker->randomElement($sumberPad),
                'sub_bidang' => $faker->randomElement($subBidang),
                'target_pad' => $target,
                'realisasi_pad' => $realisasiPad,
                'periode' => $faker->randomElement(['Q1', 'Q2', 'Q3', 'Q4']),
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 5. MODULE KEPEGAWAIAN
        $this->command->info('Seeding Kepegawaian...');
        DB::table('pegawai_mutasis')->delete();
        DB::table('pegawai_data')->delete();

        $jenisPeg = ['PNS', 'PPPK', 'Non-ASN'];
        $gol = ['III/a', 'III/b', 'III/c', 'IV/a', 'II/b'];
        $units = ['Dinas Pendidikan', 'Dinas Kesehatan', 'Bappeda', 'Inspektorat', 'Sekretariat Daerah'];

        for ($i = 0; $i < 30; $i++) {
            $nip = $faker->numerify('19##########');
            $nama = $faker->name;
            DB::table('pegawai_data')->insert([
                'nip' => $nip,
                'nama' => $nama,
                'jenis_pegawai' => $faker->randomElement($jenisPeg),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'jabatan' => 'Staf Ahli',
                'golongan' => $faker->randomElement($gol),
                'unit_kerja' => $faker->randomElement($units),
                'status_pegawai' => 'Aktif',
                'tanggal_bergabung' => Carbon::now()->subYears(rand(1, 15)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($i % 3 == 0) {
                DB::table('pegawai_mutasis')->insert([
                    'nip' => $nip,
                    'nama_pegawai' => $nama,
                    'jenis' => $faker->randomElement(['Mutasi', 'Promosi', 'Pensiun']),
                    'tanggal_efektif' => Carbon::now()->addDays(rand(1, 30)),
                    'keterangan' => 'Pengajuan bulan ini',
                    'status_pengajuan' => 'Disetujui',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // 6. MODULE KEPENDUDUKAN
        $this->command->info('Seeding Kependudukan...');
        DB::table('kependudukan_penduduks')->delete();
        DB::table('kependudukan_agamas')->delete();
        DB::table('kependudukan_wilayahs')->delete();
        DB::table('kependudukan_mutasis')->delete();

        $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
        foreach ($kecamatan as $kec) {
            for ($j=0; $j<8; $j++) {
                $laki = $faker->numberBetween(1000, 5000);
                $perempuan = $faker->numberBetween(1000, 5000);
                $total = $laki + $perempuan;
                $kel = $faker->citySuffix;

                DB::table('kependudukan_penduduks')->insert([
                    'tahun' => 2026,
                    'kecamatan' => $kec,
                    'kelurahan' => $kel,
                    'penduduk' => $total,
                    'laki_laki' => $laki,
                    'perempuan' => $perempuan,
                    'wajib_ktp' => round($total * 0.7),
                    'usia_produktif' => round($total * 0.6),
                    'anak' => round($total * 0.2),
                    'lansia' => round($total * 0.1),
                    'kk' => round($total / 4),
                    'agama' => $faker->randomElement($agamas),
                    'status' => 'Aktif',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('kependudukan_agamas')->insert([
                    'tahun' => 2026,
                    'kecamatan' => $kec,
                    'kelurahan' => $kel,
                    'agama' => $faker->randomElement($agamas),
                    'penduduk' => round($total * 0.8),
                    'persentase' => '80%',
                    'status' => 'Aktif',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('kependudukan_wilayahs')->insert([
                    'kecamatan' => $kec,
                    'kelurahan' => $kel,
                    'kode' => $faker->numerify('##.##.##.####'),
                    'penduduk' => $total,
                    'kk' => round($total / 4),
                    'laki_laki' => $laki,
                    'perempuan' => $perempuan,
                    'status' => 'Aktif',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // 7. MODULE PERIZINAN
        $this->command->info('Seeding Perizinan...');
        DB::table('perizinan_data')->delete();
        DB::table('perizinan_jenis')->delete();

        $jenisIds = [];
        $jenisNames = ['IMB', 'SIUP', 'TDP', 'Izin Reklame', 'Izin Usaha'];
        foreach($jenisNames as $jn) {
            $jenisIds[] = DB::table('perizinan_jenis')->insertGetId([
                'jenis_izin' => $jn,
                'kategori' => 'Perizinan Dasar',
                'sla' => $faker->numberBetween(3, 14) . ' Hari',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $statusIzin = ['Disetujui', 'Proses', 'Ditolak'];
        for ($i = 0; $i < 30; $i++) {
            DB::table('perizinan_data')->insert([
                'no_dokumen' => 'DOC-' . $faker->numerify('#####'),
                'nama_pemohon' => $faker->name,
                'perizinan_jenis_id' => $faker->randomElement($jenisIds),
                'jenis_permohonan' => $faker->randomElement(['Baru', 'Perpanjangan']),
                'tanggal' => Carbon::now()->subDays(rand(1, 30)),
                'status' => $faker->randomElement($statusIzin),
                'lokasi_kecamatan' => $faker->randomElement($kecamatan),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // 8. MODULE KESEHATAN
        $this->command->info('Seeding Kesehatan...');
        DB::table('kesehatan_penyakits')->truncate();

        $penyakit = ['DBD', 'ISPA', 'Diare', 'Tipes', 'Hipertensi', 'Diabetes'];
        for ($i = 0; $i < 20; $i++) {
            DB::table('kesehatan_penyakits')->insert([
                'nama' => $faker->randomElement($penyakit),
                'jumlah' => $faker->numberBetween(10, 500),
                'tahun' => 2026,
                'bulan' => $faker->randomElement(['Januari', 'Februari', 'Maret', 'April']),
                'wilayah' => $faker->randomElement($kecamatan),
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $this->command->info('Database seeding completed successfully!');
    }
}
