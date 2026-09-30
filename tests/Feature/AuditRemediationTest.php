<?php

namespace Tests\Feature;

use App\Models\Division;
use App\Models\KependudukanInformasi;
use App\Models\KependudukanPenduduk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuditRemediationTest extends TestCase
{
    use RefreshDatabase;

    public function test_division_users_can_only_view_their_own_division_and_finance_layout_resolves(): void
    {
        $finance = Division::create(['name' => 'Keuangan']);
        Division::create(['name' => 'Kesehatan']);
        $staff = User::factory()->create([
            'role' => 'user',
            'division_id' => $finance->id,
            'status' => 'aktif',
        ]);

        $this->actingAs($staff)
            ->get(route('division.users.index', 'finance'))
            ->assertOk();

        $this->get(route('division.users.index', 'kesehatan'))
            ->assertForbidden();
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('error');

        $this->assertNull($admin->fresh()->deleted_at);
    }

    public function test_role_update_accepts_division_admin(): void
    {
        $division = Division::create(['name' => 'Keuangan']);
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $staff = User::factory()->create([
            'role' => 'user',
            'division_id' => $division->id,
            'status' => 'aktif',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.roles.update', $staff), [
                'division_id' => $division->id,
                'role' => 'division_admin',
                'permissions' => ['lihat_data'],
            ])
            ->assertRedirect(route('admin.roles.index'));

        $this->assertDatabaseHas('users', [
            'id' => $staff->id,
            'role' => 'division_admin',
        ]);
    }

    public function test_penduduk_search_respects_other_filters_and_delete_route_works(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $penduduk = KependudukanPenduduk::create([
            'tahun' => 2026,
            'kecamatan' => 'Cari Utara',
            'kelurahan' => 'Wates',
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

        $this->actingAs($admin)
            ->get(route('kependudukan.data-penduduk.index', ['q' => 'Cari', 'kecamatan' => 'Magelang Tengah']))
            ->assertOk()
            ->assertDontSee('>Cari Utara</td>', false);

        $this->delete(route('kependudukan.data-penduduk.destroy', $penduduk))
            ->assertRedirect(route('kependudukan.data-penduduk.index'));

        $this->assertDatabaseMissing('kependudukan_penduduks', ['id' => $penduduk->id]);
    }

    public function test_population_pdf_route_serves_the_stored_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('kependudukan/report.pdf', '%PDF-1.4 test');
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
        $information = KependudukanInformasi::create([
            'judul' => 'Laporan',
            'kategori' => 'Mutasi',
            'file' => 'kependudukan/report.pdf',
            'tanggal' => '2026-09-28',
            'status' => 'Rilis',
        ]);

        $this->actingAs($admin)
            ->get(route('kependudukan.informasi-terbaru.pdf', $information))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
