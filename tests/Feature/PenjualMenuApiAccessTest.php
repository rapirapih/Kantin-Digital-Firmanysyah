<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenjualMenuApiAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_access_penjual_menu_api(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->getJson('/api/penjual/menus');

        $response->assertForbidden();
    }

    public function test_penjual_cannot_access_other_penjual_menu(): void
    {
        $penjualA = User::factory()->create([
            'role' => 'penjual',
        ]);

        $penjualB = User::factory()->create([
            'role' => 'penjual',
        ]);

        $menuMilikPenjualB = Menu::query()->create([
            'penjual_id' => $penjualB->id,
            'nama' => 'Ayam Geprek',
            'harga' => 17000,
            'foto' => null,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($penjualA)->getJson('/api/penjual/menus/'.$menuMilikPenjualB->id);

        $response->assertForbidden();
    }

    public function test_penjual_only_sees_their_own_menus_in_index(): void
    {
        $penjualA = User::factory()->create([
            'role' => 'penjual',
        ]);

        $penjualB = User::factory()->create([
            'role' => 'penjual',
        ]);

        $menuMilikA = Menu::query()->create([
            'penjual_id' => $penjualA->id,
            'nama' => 'Bakso',
            'harga' => 12000,
            'foto' => null,
            'status' => 'aktif',
        ]);

        $menuMilikB = Menu::query()->create([
            'penjual_id' => $penjualB->id,
            'nama' => 'Sate Ayam',
            'harga' => 20000,
            'foto' => null,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($penjualA)->getJson('/api/penjual/menus');

        $response
            ->assertOk()
            ->assertJsonFragment(['id' => $menuMilikA->id, 'nama' => 'Bakso'])
            ->assertJsonMissing(['id' => $menuMilikB->id, 'nama' => 'Sate Ayam']);
    }
}
