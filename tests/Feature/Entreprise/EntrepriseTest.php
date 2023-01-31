<?php

namespace Tests\Feature\Entreprise;

use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EntrepriseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /**@test */
    public function test_create_entreprise()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/entreprises', [
            'name' => 'test entreprise',
        ]);

        $response->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
            );
    }

    /**@test */
    public function test_update_entreprise()
    {
        $admin = User::factory()->create();

        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $response = $this->actingAs($admin)->putJson('/api/v1/admin/entreprises/' . $entreprise->id, [
            'name' => 'test entreprise updated',
        ]);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
            );
    }

    /**@test */
    public function test_delete_entreprise()
    {
        $admin = User::factory()->create();

        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $response = $this->actingAs($admin)->deleteJson('/api/v1/admin/entreprises/' . $entreprise->id);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
            );
    }

    /**@test */
    public function test_get_all_entreprise()
    {
        $response = $this->getJson('/api/v1/entreprises');

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
            );
    }

    /**@test */
    public function test_get_entreprise()
    {
        $admin = User::factory()->create();
        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $response = $this->getJson('/api/v1/entreprises/' . $entreprise->id);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
            );
    }
}
