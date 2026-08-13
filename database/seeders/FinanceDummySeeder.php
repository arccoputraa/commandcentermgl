<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinanceTax;
use App\Models\FinanceSubBidang;
use App\Models\FinanceInformation;
use Illuminate\Support\Facades\DB;

class FinanceDummySeeder extends Seeder
{
    public function run()
    {
        // Clear previous dummy data
        DB::table('finance_taxes')->truncate();
        DB::table('finance_sub_bidangs')->truncate();
        DB::table('finance_information')->truncate();

        // 1. Dummy Data for Data Pajak Daerah
        FinanceTax::create([
            'bulan' => 'Juli',
            'tahun' => 2026,
            'jenis_pajak' => 'Pajak Hotel',
            'kecamatan' => 'Magelang Tengah',
            'kelurahan' => 'Cacaban',
            'jumlah_pendapatan' => 125000000,
            'keterangan' => 'Pendapatan stabil dari musim liburan'
        ]);
        
        FinanceTax::create([
            'bulan' => 'Juli',
            'tahun' => 2026,
            'jenis_pajak' => 'Pajak Restoran',
            'kecamatan' => 'Magelang Selatan',
            'kelurahan' => 'Tidar',
            'jumlah_pendapatan' => 95000000,
            'keterangan' => 'Ada event kuliner'
        ]);
        
        FinanceTax::create([
            'bulan' => 'Agustus',
            'tahun' => 2026,
            'jenis_pajak' => 'Pajak Hiburan',
            'kecamatan' => 'Magelang Utara',
            'kelurahan' => 'Kramat Selatan',
            'jumlah_pendapatan' => 45000000,
            'keterangan' => 'Pendapatan retribusi tempat wisata'
        ]);

        // 2. Dummy Data for Sub Bidang
        FinanceSubBidang::create([
            'nama_unit' => 'Bidang Anggaran',
            'kode_unit' => 'KEU-01',
            'status' => 'Aktif',
            'deskripsi' => 'Menangani perencanaan dan penyusunan APBD',
            'jumlah_staff' => 12
        ]);
        
        FinanceSubBidang::create([
            'nama_unit' => 'Bidang Perbendaharaan',
            'kode_unit' => 'KEU-02',
            'status' => 'Aktif',
            'deskripsi' => 'Pengelolaan kas daerah',
            'jumlah_staff' => 15
        ]);
        
        FinanceSubBidang::create([
            'nama_unit' => 'Bidang Akuntansi',
            'kode_unit' => 'KEU-03',
            'status' => 'Aktif',
            'deskripsi' => 'Penyusunan laporan keuangan pemerintah daerah',
            'jumlah_staff' => 10
        ]);

        // 3. Dummy Data for Information (Publikasi)
        FinanceInformation::create([
            'judul' => 'Ringkasan APBD 2026 Kota Magelang',
            'kategori' => 'Dokumen Anggaran',
            'format' => 'PDF',
            'dokumen' => '/dokumen/apbd-2026.pdf',
            'status_publikasi' => 'Rilis',
            'keterangan' => 'Disahkan bulan Desember 2025'
        ]);
        
        FinanceInformation::create([
            'judul' => 'LKPJ Walikota Tahun 2025 Bidang Keuangan',
            'kategori' => 'Laporan Kinerja',
            'format' => 'PDF',
            'dokumen' => '/dokumen/lkpj-2025.pdf',
            'status_publikasi' => 'Rilis',
            'keterangan' => 'Laporan keterangan pertanggungjawaban'
        ]);
        
        FinanceInformation::create([
            'judul' => 'Draft Laporan Realisasi Anggaran Kuartal 3 2026',
            'kategori' => 'Laporan Keuangan',
            'format' => 'Excel',
            'dokumen' => '/dokumen/lra-q3-2026.xlsx',
            'status_publikasi' => 'Draft',
            'keterangan' => 'Masih dalam proses reviu inspektorat'
        ]);
        
        FinanceInformation::create([
            'judul' => 'Pedoman Teknis Pengelolaan Keuangan Daerah',
            'kategori' => 'Peraturan',
            'format' => 'PDF',
            'dokumen' => '/dokumen/pedoman-keuangan.pdf',
            'status_publikasi' => 'Rilis',
            'keterangan' => 'Update perwal 2026'
        ]);
    }
}
