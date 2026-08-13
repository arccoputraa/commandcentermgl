<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PegawaiData;
use App\Models\PegawaiJabatan;
use App\Models\PegawaiMutasi;
use App\Models\PegawaiInformasi;
use Illuminate\Support\Facades\DB;

class KepegawaianDummySeeder extends Seeder
{
    public function run()
    {
        // Clear previous dummy data
        DB::table('pegawai_data')->truncate();
        DB::table('pegawai_jabatans')->truncate();
        DB::table('pegawai_mutasis')->truncate();
        DB::table('pegawai_informasis')->truncate();

        // 1. Dummy Data Pegawai
        PegawaiData::create([
            'nip' => '198001012005011001',
            'nama' => 'Budi Santoso, M.Si',
            'jenis_pegawai' => 'PNS',
            'jenis_kelamin' => 'Laki-laki',
            'jabatan' => 'Kepala Bidang',
            'golongan' => 'IV/a',
            'unit_kerja' => 'Sekretariat',
            'status_pegawai' => 'Aktif',
            'tanggal_bergabung' => '2005-01-01'
        ]);
        
        PegawaiData::create([
            'nip' => '198502022010012002',
            'nama' => 'Siti Aminah, S.Kom',
            'jenis_pegawai' => 'PPPK',
            'jenis_kelamin' => 'Perempuan',
            'jabatan' => 'Analis Kepegawaian',
            'golongan' => 'III/c',
            'unit_kerja' => 'Data Kepegawaian',
            'status_pegawai' => 'Aktif',
            'tanggal_bergabung' => '2010-01-01'
        ]);
        
        PegawaiData::create([
            'nip' => '199003032015021003',
            'nama' => 'Rahmat Hidayat',
            'jenis_pegawai' => 'Non-ASN',
            'jenis_kelamin' => 'Laki-laki',
            'jabatan' => 'Staf Administrasi',
            'golongan' => 'II/c',
            'unit_kerja' => 'Mutasi',
            'status_pegawai' => 'Tugas Belajar',
            'tanggal_bergabung' => '2015-02-01'
        ]);

        // 2. Dummy Jabatan & Unit Kerja
        PegawaiJabatan::create([
            'nama_jabatan' => 'Sekretariat',
            'kode_unit' => 'SEK-01',
            'jabatan_utama' => 'Kepala Subbagian Umum',
            'deskripsi_unit' => 'Membawahi administrasi umum dan kepegawaian',
            'eselon' => 'II.b',
            'jumlah_pegawai' => 28,
            'status' => 'Aktif'
        ]);
        
        PegawaiJabatan::create([
            'nama_jabatan' => 'Bidang Mutasi',
            'kode_unit' => 'MUT-01',
            'jabatan_utama' => 'Kepala Bidang Mutasi',
            'deskripsi_unit' => 'Mengurus mutasi dan promosi pegawai',
            'eselon' => 'III.a',
            'jumlah_pegawai' => 21,
            'status' => 'Aktif'
        ]);
        
        PegawaiJabatan::create([
            'nama_jabatan' => 'Data Kepegawaian',
            'kode_unit' => 'DK-01',
            'jabatan_utama' => 'Kepala Bidang Data',
            'deskripsi_unit' => 'Mengelola data dan sistem informasi pegawai',
            'eselon' => 'III.a',
            'jumlah_pegawai' => 34,
            'status' => 'Aktif'
        ]);

        // 3. Dummy Mutasi & Pensiun
        PegawaiMutasi::create([
            'nip' => '198001012005011001',
            'nama_pegawai' => 'Budi Santoso, M.Si',
            'jenis' => 'Mutasi',
            'tanggal_efektif' => '2026-09-01',
            'status_pengajuan' => 'Proses',
            'keterangan' => 'Mutasi rotasi antar dinas'
        ]);

        PegawaiMutasi::create([
            'nip' => '196812121990031001',
            'nama_pegawai' => 'Agus Yulianto',
            'jenis' => 'Pensiun',
            'tanggal_efektif' => '2026-12-01',
            'status_pengajuan' => 'Disetujui',
            'keterangan' => 'Pensiun batas usia'
        ]);

        // 4. Dummy Informasi
        PegawaiInformasi::create([
            'judul' => 'Pengumuman Seleksi CPNS 2026',
            'kategori' => 'Pengumuman',
            'format' => 'PDF',
            'dokumen' => '/dokumen/pengumuman-cpns-2026.pdf',
            'status_publikasi' => 'Rilis',
            'keterangan' => 'Informasi formasi CPNS Kota Magelang'
        ]);
        
        PegawaiInformasi::create([
            'judul' => 'Edaran Penyesuaian Jam Kerja ASN',
            'kategori' => 'Surat Edaran',
            'format' => 'PDF',
            'dokumen' => '/dokumen/se-jam-kerja.pdf',
            'status_publikasi' => 'Rilis',
            'keterangan' => 'Berlaku mulai Oktober 2026'
        ]);
    }
}
