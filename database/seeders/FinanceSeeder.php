<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinanceBudget;
use App\Models\FinancePad;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Data Anggaran & Realisasi Dummy
        $budgets = [
            [
                'tahun' => 2026,
                'sub_bidang' => 'Dinas Pendidikan',
                'nama_anggaran' => 'Belanja Modal Pengadaan Perangkat Komputer',
                'total_anggaran' => 1250000000,
                'total_realisasi' => 1150000000,
                'periode' => 'Semester 1',
                'status' => 'Berjalan',
                'catatan_internal' => 'Proses pengadaan sedang berlangsung sesuai jadwal.'
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Dinas Kesehatan',
                'nama_anggaran' => 'Pengadaan Obat dan Vaksin',
                'total_anggaran' => 4500000000,
                'total_realisasi' => 4200000000,
                'periode' => 'Kuartal 2',
                'status' => 'Mendekati Limit',
                'catatan_internal' => 'Anggaran menipis, perlu evaluasi pengadaan obat tambahan.'
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Dinas Pekerjaan Umum',
                'nama_anggaran' => 'Perbaikan Jalan Raya Protokol',
                'total_anggaran' => 8500000000,
                'total_realisasi' => 3400000000,
                'periode' => 'Juli 2026',
                'status' => 'Berjalan',
                'catatan_internal' => 'Fase 1 perbaikan selesai, menunggu pencairan fase 2.'
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Dinas Lingkungan Hidup',
                'nama_anggaran' => 'Pengadaan Armada Truk Sampah',
                'total_anggaran' => 3200000000,
                'total_realisasi' => 3200000000,
                'periode' => 'Semester 1',
                'status' => 'Overbudget',
                'catatan_internal' => 'Harga truk naik akibat inflasi suku cadang.'
            ],
            [
                'tahun' => 2026,
                'sub_bidang' => 'Sekretariat Daerah',
                'nama_anggaran' => 'Pemeliharaan Gedung Pemkot',
                'total_anggaran' => 1450000000,
                'total_realisasi' => 950000000,
                'periode' => 'Agustus 2026',
                'status' => 'Berjalan',
                'catatan_internal' => 'Pengecatan ulang dan perbaikan atap bocor.'
            ],
        ];

        foreach ($budgets as $b) {
            FinanceBudget::create($b);
        }

        // 2. Data PAD Dummy
        $pads = [
            [
                'tahun' => 2026,
                'sumber_pendapatan' => 'Pajak Daerah',
                'sub_bidang' => 'Bidang Pajak',
                'target_pad' => 15000000000,
                'realisasi_pad' => 16500000000,
                'periode' => 'Agustus 2026',
                'status' => 'Melebihi Target',
                'catatan_internal' => 'Penerimaan PBB meningkat drastis berkat program pemutihan denda.'
            ],
            [
                'tahun' => 2026,
                'sumber_pendapatan' => 'Retribusi Daerah',
                'sub_bidang' => 'Bidang Pendapatan',
                'target_pad' => 4500000000,
                'realisasi_pad' => 3200000000,
                'periode' => 'Juli 2026',
                'status' => 'Berjalan',
                'catatan_internal' => 'Target retribusi parkir masih belum tercapai.'
            ],
            [
                'tahun' => 2026,
                'sumber_pendapatan' => 'Hasil Pengelolaan Kekayaan Daerah',
                'sub_bidang' => 'Bidang Aset',
                'target_pad' => 1200000000,
                'realisasi_pad' => 850000000,
                'periode' => 'Semester 1',
                'status' => 'Berjalan',
                'catatan_internal' => 'Dividen BUMD baru akan disetor di Q4.'
            ],
            [
                'tahun' => 2026,
                'sumber_pendapatan' => 'Lain-lain PAD yang Sah',
                'sub_bidang' => 'Bidang Pendapatan',
                'target_pad' => 400000000,
                'realisasi_pad' => 450000000,
                'periode' => 'Agustus 2026',
                'status' => 'Melebihi Target',
                'catatan_internal' => 'Pendapatan jasa giro meningkat.'
            ],
        ];

        foreach ($pads as $p) {
            FinancePad::create($p);
        }
    }
}
