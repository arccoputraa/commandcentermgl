<?php

namespace Tests\Feature;

use App\Models\DataSpasial;
use App\Models\LayerSig;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSectorDataEmptyStateTest extends TestCase
{
    use RefreshDatabase;

    public function test_finance_page_does_not_render_demo_values_or_documents_when_empty(): void
    {
        $this->get(route('layanan', ['dept' => 'keuangan']))
            ->assertOk()
            ->assertSee('Belum tersedia')
            ->assertSee('Data anggaran belum tersedia.')
            ->assertSee('Belum ada informasi keuangan yang dipublikasikan.')
            ->assertDontSee('Rp22,4 M')
            ->assertDontSee('sample-document.pdf');
    }

    public function test_health_page_shows_empty_states_without_sample_charts_or_documents(): void
    {
        $this->get(route('layanan', ['dept' => 'kesehatan']))
            ->assertOk()
            ->assertSee('Data kasus kesehatan belum tersedia.')
            ->assertSee('Data penyakit belum tersedia.')
            ->assertSee('Belum ada informasi tersedia.')
            ->assertDontSee('ISPA')
            ->assertDontSee('sample-laporan-keuangan.pdf');
    }

    public function test_sig_page_shows_empty_states_without_demo_map_points_or_documents(): void
    {
        $this->get(route('layanan', ['dept' => 'sig']))
            ->assertOk()
            ->assertSee('Belum ada layer publik yang tersedia.')
            ->assertSee('Belum ada koordinat data untuk ditampilkan pada peta.')
            ->assertSee('Belum ada informasi SIG yang dipublikasikan.')
            ->assertDontSee('Mata Air Kota Magelang')
            ->assertDontSee('sample-document.pdf');
    }

    public function test_sig_page_only_shows_data_from_active_public_layers(): void
    {
        $publicLayer = LayerSig::create(['nama_layer' => 'Layer Publik', 'status_aktif' => true]);
        $inactiveLayer = LayerSig::create(['nama_layer' => 'Layer Internal', 'status_aktif' => false]);

        DataSpasial::create([
            'layer_id' => $publicLayer->id,
            'nama_data' => 'Data Spasial Publik',
            'kategori' => 'Fasilitas',
            'wilayah' => 'Magelang Tengah',
            'nilai_jumlah' => 3,
            'latitude' => -7.4797,
            'longitude' => 110.2177,
        ]);
        DataSpasial::create([
            'layer_id' => $inactiveLayer->id,
            'nama_data' => 'Data Spasial Internal',
            'kategori' => 'Internal',
            'wilayah' => 'Magelang Utara',
            'nilai_jumlah' => 7,
            'latitude' => -7.48,
            'longitude' => 110.21,
        ]);

        $this->get(route('layanan', ['dept' => 'sig']))
            ->assertOk()
            ->assertSee('Layer Publik')
            ->assertSee('Data Spasial Publik')
            ->assertDontSee('Layer Internal')
            ->assertDontSee('Data Spasial Internal');
    }
}
