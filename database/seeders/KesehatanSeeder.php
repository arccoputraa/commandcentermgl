<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KesehatanPenyakit;

class KesehatanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'ISPA', 'jumlah' => 850, 'tahun' => 2026, 'bulan' => 'Februari', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'Hipertensi', 'jumlah' => 620, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'Diabetes', 'jumlah' => 540, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'Diare', 'jumlah' => 310, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'Demam Berdarah (DBD)', 'jumlah' => 280, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'Stunting', 'jumlah' => 210, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'TBC', 'jumlah' => 180, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'Pneumonia', 'jumlah' => 150, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
            ['nama' => 'Asma', 'jumlah' => 120, 'tahun' => 2026, 'bulan' => 'Maret', 'wilayah' => 'Semua', 'status' => 'Aktif'],
        ];

        foreach ($data as $item) {
            KesehatanPenyakit::create($item);
        }
    }
}
