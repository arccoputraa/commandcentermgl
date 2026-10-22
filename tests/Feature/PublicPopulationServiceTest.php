<?php

namespace Tests\Feature;

use App\Models\KependudukanMutasi;
use App\Models\KependudukanPenduduk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPopulationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_population_filters_update_the_summary_charts_and_table(): void
    {
        $year = now()->year;

        $this->createPopulation([
            'tahun' => $year,
            'kecamatan' => 'Magelang Selatan',
            'kelurahan' => 'Tidar Selatan',
            'penduduk' => 1000,
            'laki_laki' => 480,
            'perempuan' => 520,
            'wajib_ktp' => 700,
            'usia_produktif' => 650,
            'kk' => 300,
            'agama' => 'Islam',
        ]);

        $this->createPopulation([
            'tahun' => $year,
            'kecamatan' => 'Magelang Utara',
            'kelurahan' => 'Wates',
            'penduduk' => 400,
            'laki_laki' => 190,
            'perempuan' => 210,
            'wajib_ktp' => 280,
            'usia_produktif' => 250,
            'kk' => 120,
            'agama' => 'Kristen',
        ]);

        KependudukanMutasi::create([
            'tahun' => $year,
            'bulan' => 'Januari',
            'kecamatan' => 'Magelang Selatan',
            'kelurahan' => 'Tidar Selatan',
            'kelahiran' => 12,
            'kematian' => 5,
            'pindah_datang' => 3,
            'pindah_keluar' => 2,
            'status' => 'Aktif',
        ]);

        KependudukanMutasi::create([
            'tahun' => $year - 1,
            'bulan' => 'Desember',
            'kecamatan' => 'Magelang Selatan',
            'kelurahan' => 'Tidar Selatan',
            'kelahiran' => 99,
            'kematian' => 88,
            'pindah_datang' => 0,
            'pindah_keluar' => 0,
            'status' => 'Aktif',
        ]);

        $this->get(route('layanan', [
            'dept' => 'kependudukan',
            'kecamatan' => 'Magelang Selatan',
            'kelurahan' => 'Tidar Selatan',
            'tahun' => $year,
            'agama' => 'Islam',
        ]))
            ->assertOk()
            ->assertSee('1.000 Jiwa')
            ->assertSee('480 Jiwa')
            ->assertSee('12 Jiwa')
            ->assertSee('5 Jiwa')
            ->assertSee('<td>Tidar Selatan</td>', false)
            ->assertDontSee('<td>Wates</td>', false);
    }

    public function test_non_active_status_filter_is_reflected_in_the_summary_and_table(): void
    {
        $this->createPopulation([
            'tahun' => now()->year,
            'kecamatan' => 'Magelang Tengah',
            'kelurahan' => 'Cacaban',
            'penduduk' => 250,
            'laki_laki' => 120,
            'perempuan' => 130,
            'wajib_ktp' => 180,
            'usia_produktif' => 160,
            'kk' => 75,
            'agama' => 'Islam',
            'status' => 'Nonaktif',
        ]);

        $this->get(route('layanan', [
            'dept' => 'kependudukan',
            'status' => 'Nonaktif',
        ]))
            ->assertOk()
            ->assertSee('250 Jiwa')
            ->assertSee('<td>Cacaban</td>', false)
            ->assertSee('Nonaktif');
    }

    private function createPopulation(array $attributes): KependudukanPenduduk
    {
        return KependudukanPenduduk::create(array_merge([
            'anak' => 100,
            'lansia' => 50,
            'status' => 'Aktif',
        ], $attributes));
    }
}
