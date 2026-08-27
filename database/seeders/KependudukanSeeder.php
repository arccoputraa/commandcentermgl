<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KependudukanSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPenduduk = [
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'penduduk' => 8240, 'laki_laki' => 4090, 'perempuan' => 4150, 'wajib_ktp' => 6120, 'usia_produktif' => 5430, 'anak' => 1620, 'lansia' => 1190, 'kk' => 2340, 'agama' => 'Islam', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'penduduk' => 7850, 'laki_laki' => 3920, 'perempuan' => 3930, 'wajib_ktp' => 5870, 'usia_produktif' => 5110, 'anak' => 1510, 'lansia' => 1110, 'kk' => 2180, 'agama' => 'Islam', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'penduduk' => 6730, 'laki_laki' => 3310, 'perempuan' => 3420, 'wajib_ktp' => 5020, 'usia_produktif' => 4480, 'anak' => 1320, 'lansia' => 930, 'kk' => 1920, 'agama' => 'Islam', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Kemirirejo', 'penduduk' => 5980, 'laki_laki' => 2930, 'perempuan' => 3050, 'wajib_ktp' => 4460, 'usia_produktif' => 3920, 'anak' => 1190, 'lansia' => 870, 'kk' => 1710, 'agama' => 'Islam', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Tidar Selatan', 'penduduk' => 6410, 'laki_laki' => 3180, 'perempuan' => 3230, 'wajib_ktp' => 4800, 'usia_produktif' => 4210, 'anak' => 1250, 'lansia' => 950, 'kk' => 1860, 'agama' => 'Islam', 'status' => 'Aktif'],
        ];
        foreach($defaultPenduduk as $d) {
            $d['created_at'] = now();
            $d['updated_at'] = now();
            DB::table('kependudukan_penduduks')->insert($d);
        }

        $defaultAgama = [
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Islam', 'penduduk' => 5120, 'persentase' => '62%', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Kristen', 'penduduk' => 1120, 'persentase' => '14%', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Katolik', 'penduduk' => 980, 'persentase' => '12%', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'agama' => 'Islam', 'penduduk' => 5840, 'persentase' => '74%', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'agama' => 'Islam', 'penduduk' => 4910, 'persentase' => '73%', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'agama' => 'Hindu', 'penduduk' => 140, 'persentase' => '2%', 'status' => 'Aktif'],
        ];
        foreach($defaultAgama as $d) {
            $d['created_at'] = now();
            $d['updated_at'] = now();
            DB::table('kependudukan_agamas')->insert($d);
        }

        $defaultWilayah = [
            ['kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'kode' => '3371011001', 'penduduk' => 8240, 'kk' => 2340, 'laki_laki' => 4090, 'perempuan' => 4150, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'kode' => '3371021002', 'penduduk' => 7850, 'kk' => 2180, 'laki_laki' => 3920, 'perempuan' => 3930, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'kode' => '3371031003', 'penduduk' => 6730, 'kk' => 1920, 'laki_laki' => 3310, 'perempuan' => 3420, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Kemirirejo', 'kode' => '3371011004', 'penduduk' => 5980, 'kk' => 1710, 'laki_laki' => 2930, 'perempuan' => 3050, 'status' => 'Aktif'],
            ['kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Tidar Selatan', 'kode' => '3371021005', 'penduduk' => 6410, 'kk' => 1860, 'laki_laki' => 3180, 'perempuan' => 3230, 'status' => 'Aktif'],
        ];
        foreach($defaultWilayah as $d) {
            $d['created_at'] = now();
            $d['updated_at'] = now();
            DB::table('kependudukan_wilayahs')->insert($d);
        }

        $defaultKK = [
            ['tahun' => 2026, 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'kk' => 2340, 'penduduk' => 8240, 'rata_rata' => '3,5 orang', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'kk' => 2180, 'penduduk' => 7850, 'rata_rata' => '3,6 orang', 'status' => 'Aktif'],
            ['tahun' => 2026, 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'kk' => 1920, 'penduduk' => 6730, 'rata_rata' => '3,5 orang', 'status' => 'Aktif'],
        ];
        foreach($defaultKK as $d) {
            $d['created_at'] = now();
            $d['updated_at'] = now();
            DB::table('kependudukan_kartu_keluargas')->insert($d);
        }

        $defaultMutasi = [
            ['tahun' => 2026, 'bulan' => 'Januari', 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Panjang', 'kelahiran' => 18, 'kematian' => 7, 'pindah_datang' => 24, 'pindah_keluar' => 15, 'status' => 'Aktif'],
            ['tahun' => 2026, 'bulan' => 'Februari', 'kecamatan' => 'Magelang Selatan', 'kelurahan' => 'Jurangombo Utara', 'kelahiran' => 21, 'kematian' => 9, 'pindah_datang' => 18, 'pindah_keluar' => 12, 'status' => 'Aktif'],
            ['tahun' => 2026, 'bulan' => 'Maret', 'kecamatan' => 'Magelang Utara', 'kelurahan' => 'Kedungsari', 'kelahiran' => 15, 'kematian' => 6, 'pindah_datang' => 20, 'pindah_keluar' => 14, 'status' => 'Aktif'],
            ['tahun' => 2026, 'bulan' => 'April', 'kecamatan' => 'Magelang Tengah', 'kelurahan' => 'Kemirirejo', 'kelahiran' => 12, 'kematian' => 5, 'pindah_datang' => 16, 'pindah_keluar' => 10, 'status' => 'Aktif'],
        ];
        foreach($defaultMutasi as $d) {
            $d['created_at'] = now();
            $d['updated_at'] = now();
            DB::table('kependudukan_mutasis')->insert($d);
        }

        $defaultInfo = [
            ['judul' => 'Rekap Data Kependudukan Semester I 2026', 'kategori' => 'Rekap Penduduk', 'file' => 'rekap-penduduk-semester-1.pdf', 'tanggal' => '2026-07-03', 'status' => 'Rilis'],
            ['judul' => 'Statistik Pemeluk Agama 2026', 'kategori' => 'Data Agama', 'file' => 'statistik-agama-2026.pdf', 'tanggal' => '2026-07-02', 'status' => 'Rilis'],
            ['judul' => 'Laporan Mutasi Penduduk Juni 2026', 'kategori' => 'Mutasi Penduduk', 'file' => 'mutasi-penduduk-juni.pdf', 'tanggal' => '2026-07-01', 'status' => 'Rilis'],
            ['judul' => 'Publikasi Penduduk Berdasarkan Wilayah', 'kategori' => 'Statistik Wilayah', 'file' => 'penduduk-wilayah-2026.pdf', 'tanggal' => '2026-06-30', 'status' => 'Draft'],
        ];
        foreach($defaultInfo as $d) {
            $d['created_at'] = now();
            $d['updated_at'] = now();
            DB::table('kependudukan_informasis')->insert($d);
        }
    }
}
