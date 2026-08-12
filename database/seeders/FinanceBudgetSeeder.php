<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinanceBudget;

class FinanceBudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tahun' => 2026,
                'sub_bidang' => 'Sekretariat',
                'nama_anggaran' => 'Belanja Operasional',
                'total_anggaran' => 5200000000,
                'total_realisasi' => 4400000000,
                'periode' => 'Juli 2026',
                'status' => 'Berjalan',
                'catatan_internal' => 'Pelaksanaan program berjalan sesuai dengan jadwal yang telah ditetapkan.',
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Bidang Anggaran',
                'nama_anggaran' => 'Penyusunan Anggaran Tahunan',
                'total_anggaran' => 1500000000,
                'total_realisasi' => 1200000000,
                'periode' => 'Juli 2026',
                'status' => 'Berjalan',
                'catatan_internal' => 'Proses penyusunan berjalan lancar, sedang dalam tahap review akhir.',
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Bidang Akuntansi',
                'nama_anggaran' => 'Pelaporan Keuangan',
                'total_anggaran' => 2000000000,
                'total_realisasi' => 1800000000,
                'periode' => 'Juli 2026',
                'status' => 'Hampir Tercapai',
                'catatan_internal' => 'Target pelaporan kuartal hampir selesai dikompilasi.',
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Bidang Aset',
                'nama_anggaran' => 'Pengelolaan Aset Daerah',
                'total_anggaran' => 2800000000,
                'total_realisasi' => 2100000000,
                'periode' => 'Juli 2026',
                'status' => 'Perlu Perhatian',
                'catatan_internal' => 'Terdapat beberapa kendala dalam proses inventarisasi aset di lapangan yang mengakibatkan sedikit keterlambatan.',
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Bidang Pajak',
                'nama_anggaran' => 'Pengawasan Pajak Daerah',
                'total_anggaran' => 5000000000,
                'total_realisasi' => 4200000000,
                'periode' => 'Juli 2026',
                'status' => 'Berjalan',
                'catatan_internal' => 'Pengawasan rutin sedang berjalan di berbagai sektor usaha.',
            ],
        ];

        foreach ($data as $item) {
            FinanceBudget::create($item);
        }
    }
}
