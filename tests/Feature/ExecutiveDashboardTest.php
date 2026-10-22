<?php

namespace Tests\Feature;

use App\Models\Division;
use App\Models\FinanceBudget;
use App\Models\KependudukanPenduduk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExecutiveDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_selected_year_filters_financial_summary_and_is_shown_in_the_dashboard(): void
    {
        $selectedYear = now()->year - 1;

        FinanceBudget::create([
            'tahun' => $selectedYear,
            'sub_bidang' => 'Bidang A',
            'nama_anggaran' => 'Anggaran Terpilih',
            'total_anggaran' => 5000,
            'total_realisasi' => 1234,
        ]);

        FinanceBudget::create([
            'tahun' => now()->year,
            'sub_bidang' => 'Bidang B',
            'nama_anggaran' => 'Anggaran Tahun Berjalan',
            'total_anggaran' => 9999,
            'total_realisasi' => 8888,
        ]);

        $division = Division::create(['name' => 'Kependudukan']);
        KependudukanPenduduk::create([
            'tahun' => $selectedYear,
            'kecamatan' => 'Magelang Tengah',
            'kelurahan' => 'Cacaban',
            'penduduk' => 100,
            'laki_laki' => 50,
            'perempuan' => 50,
            'wajib_ktp' => 70,
            'usia_produktif' => 60,
            'anak' => 20,
            'lansia' => 10,
            'kk' => 25,
            'agama' => 'Islam',
            'status' => 'Aktif',
        ]);
        KependudukanPenduduk::create([
            'tahun' => now()->year,
            'kecamatan' => 'Magelang Tengah',
            'kelurahan' => 'Cacaban',
            'penduduk' => 200,
            'laki_laki' => 100,
            'perempuan' => 100,
            'wajib_ktp' => 140,
            'usia_produktif' => 120,
            'anak' => 40,
            'lansia' => 20,
            'kk' => 50,
            'agama' => 'Islam',
            'status' => 'Aktif',
        ]);

        $this->get(route('dashboard.eksekutif', ['year' => $selectedYear]))
            ->assertOk()
            ->assertSee("Tahun {$selectedYear}")
            ->assertSee("Data Registrasi Penduduk Tahun {$selectedYear}")
            ->assertSee('Rp 1.234')
            ->assertDontSee('Rp 8.888')
            ->assertSee('Data terakhir berubah:')
            ->assertSee('preview-chart-city-0')
            ->assertSee("preview-chart-{$division->id}-0");
    }
}
