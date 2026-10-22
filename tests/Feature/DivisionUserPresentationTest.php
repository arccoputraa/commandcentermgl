<?php

namespace Tests\Feature;

use App\Models\Division;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DivisionUserPresentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_division_user_create_and_edit_forms_render_responsive_layout(): void
    {
        $division = Division::create(['name' => 'Keuangan']);
        $manager = User::factory()->create([
            'role' => 'division_admin',
            'division_id' => $division->id,
            'status' => 'aktif',
        ]);
        $staff = User::factory()->create([
            'role' => 'user',
            'division_id' => $division->id,
            'status' => 'aktif',
        ]);

        $this->actingAs($manager)
            ->withSession(['_old_input' => ['permissions' => ['lihat_data']]])
            ->get(route('division.users.create', 'finance'))
            ->assertOk()
            ->assertSee('division-user-fields', false)
            ->assertSee('division-user-permissions', false)
            ->assertSee('value="lihat_data" style="width: 16px; height: 16px;" checked', false);

        $this->get(route('division.users.edit', ['finance', $staff]))
            ->assertOk()
            ->assertSee('division-user-fields', false)
            ->assertSee('division-user-permissions', false);
    }
}
