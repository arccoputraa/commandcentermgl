<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerizinanJenis;
use App\Models\PerizinanData;
use Carbon\Carbon;

class PerizinanSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Jenis Izin
        $jenisIzinData = [
            [
                'jenis_izin' => 'Izin Mendirikan Bangunan (IMB)',
                'kategori' => 'Konstruksi',
                'sla' => '14 Hari Kerja',
                'status' => 'Aktif',
                'keterangan' => 'Izin yang dikeluarkan untuk pembangunan gedung dan bangunan fisik.'
            ],
            [
                'jenis_izin' => 'Surat Izin Usaha Perdagangan (SIUP)',
                'kategori' => 'Perdagangan',
                'sla' => '5 Hari Kerja',
                'status' => 'Aktif',
                'keterangan' => 'Izin operasional bagi usaha perdagangan barang/jasa.'
            ],
            [
                'jenis_izin' => 'Izin Pemasangan Reklame',
                'kategori' => 'Komersial',
                'sla' => '7 Hari Kerja',
                'status' => 'Aktif',
                'keterangan' => 'Izin untuk memasang iklan dan reklame di ruang publik.'
            ],
            [
                'jenis_izin' => 'Izin Usaha Industri',
                'kategori' => 'Industri',
                'sla' => '10 Hari Kerja',
                'status' => 'Aktif',
                'keterangan' => 'Izin operasional pabrik atau kegiatan manufaktur skala menengah-besar.'
            ],
        ];

        $jenisMap = [];
        foreach ($jenisIzinData as $jenis) {
            $created = PerizinanJenis::create($jenis);
            $jenisMap[$created->jenis_izin] = $created->id;
        }

        // 2. Seed Data Perizinan
        $perizinanData = [
            [
                'no_dokumen' => 'IZN/2026/08/001',
                'nama_pemohon' => 'PT. Maju Mundur Sejahtera',
                'perizinan_jenis_id' => $jenisMap['Izin Mendirikan Bangunan (IMB)'],
                'jenis_permohonan' => 'Baru',
                'tanggal' => Carbon::today()->format('Y-m-d'),
                'status' => 'Proses',
                'lokasi_kecamatan' => 'Magelang Tengah',
                'keterangan' => 'Pembangunan Ruko 3 Lantai.'
            ],
            [
                'no_dokumen' => 'IZN/2026/08/002',
                'nama_pemohon' => 'CV. Berkah Abadi',
                'perizinan_jenis_id' => $jenisMap['Surat Izin Usaha Perdagangan (SIUP)'],
                'jenis_permohonan' => 'Perpanjangan',
                'tanggal' => Carbon::yesterday()->format('Y-m-d'),
                'status' => 'Disetujui',
                'lokasi_kecamatan' => 'Magelang Selatan',
                'keterangan' => 'Usaha minimarket.'
            ],
            [
                'no_dokumen' => 'IZN/2026/08/003',
                'nama_pemohon' => 'Budi Santoso',
                'perizinan_jenis_id' => $jenisMap['Izin Pemasangan Reklame'],
                'jenis_permohonan' => 'Baru',
                'tanggal' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'status' => 'Disetujui',
                'lokasi_kecamatan' => 'Magelang Utara',
                'keterangan' => 'Baliho Pilkada 2026.'
            ],
            [
                'no_dokumen' => 'IZN/2026/08/004',
                'nama_pemohon' => 'PT. Industri Magelang',
                'perizinan_jenis_id' => $jenisMap['Izin Usaha Industri'],
                'jenis_permohonan' => 'Baru',
                'tanggal' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'status' => 'Ditolak',
                'lokasi_kecamatan' => 'Magelang Selatan',
                'keterangan' => 'Dokumen AMDAL tidak lengkap.'
            ],
            [
                'no_dokumen' => 'IZN/2026/08/005',
                'nama_pemohon' => 'Andi Wijaya',
                'perizinan_jenis_id' => $jenisMap['Izin Mendirikan Bangunan (IMB)'],
                'jenis_permohonan' => 'Perubahan',
                'tanggal' => Carbon::today()->format('Y-m-d'),
                'status' => 'Proses',
                'lokasi_kecamatan' => 'Magelang Tengah',
                'keterangan' => 'Penambahan lantai garasi.'
            ],
            [
                'no_dokumen' => 'IZN/2026/08/006',
                'nama_pemohon' => 'Siti Aminah',
                'perizinan_jenis_id' => $jenisMap['Surat Izin Usaha Perdagangan (SIUP)'],
                'jenis_permohonan' => 'Baru',
                'tanggal' => Carbon::today()->format('Y-m-d'),
                'status' => 'Proses',
                'lokasi_kecamatan' => 'Magelang Utara',
                'keterangan' => 'Usaha katering makanan.'
            ]
        ];

        foreach ($perizinanData as $data) {
            PerizinanData::create($data);
        }
    }
}
