<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function update_user_information()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson('/api/v1/users/info', [
            'first_name' => 'test',
            'last_name' => 'test',
            'username' => 'test',
            'phone_numbre' => '0123456789',
            'email' => 'test@gmail.com',
        ]);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
            );
    }

    /** @test */
    public function update_user_password_if_old_password_incorrect(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson('/api/v1/users/password', [
            'old_password' => 'testtest',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
                    ->has('errors')
            );
    }

    /** @test */
    public function update_user_password_if_old_password_correct(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson('/api/v1/users/password', [
            'old_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
            );
    }

    /** @test */
    public function update_user_password_if_new_password_same_old_password(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->putJson('/api/v1/users/password', [
            'old_password' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
                    ->has('errors')
            );
    }
}
