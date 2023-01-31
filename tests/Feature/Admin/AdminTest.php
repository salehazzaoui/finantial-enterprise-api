<?php

namespace Tests\Feature\Admin;

use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /**@test */
    public function test_add_user_to_entrprise()
    {
        $admin = User::factory()->create();
        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/users/' . $admin->id . '/entreprise/' . $entreprise->id);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
            );
    }

    /**@test */
    public function test_search_users()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->getJson('/api/v1/admin/users');

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data')
            );
    }

    /**@test */
    public function test_create_user()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->postJson('/api/v1/admin/users', [
            'first_name' => 'test',
            'last_name' => 'test',
            'username' => 'testtest',
            'phone_numbre' => '0657352845',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('user')
            );
    }

    /**@test */
    public function test_update_user()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create([
            'phone_numbre' => '0654123545'
        ]);

        $response = $this->actingAs($admin)->putJson('/api/v1/admin/users/' . $user->id, [
            'first_name' => 'test',
            'last_name' => 'test',
            'username' => 'testtest',
            'phone_numbre' => '0657352845',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('user')
            );
    }

    /**@test */
    public function test_delete_user()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create([
            'phone_numbre' => '0654123545'
        ]);

        $response = $this->actingAs($admin)->deleteJson('/api/v1/admin/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
            );
    }
}
