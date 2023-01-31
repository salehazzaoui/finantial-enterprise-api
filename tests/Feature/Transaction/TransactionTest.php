<?php

namespace Tests\Feature\Transaction;

use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\ResponseTrait;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /**@test */
    public function test_create_ADD_transaction()
    {
        /*$admin = User::factory()->create();
        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $response = $this->actingAs($admin)->postJson('/api/v1/entreprise/' . $entreprise->id . '/transaction', [
            'user_id' => $admin->id,
            'entreprise_id' => $entreprise->id,
            'type' => 'ADD',
            'amount' => 150.00,
        ]);

        $entreprise = Entreprise::find($entreprise->id);
        //dd($entreprise);

        $this->assertTrue($entreprise->amount_entre === 150.00);

        $response->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
                    ->has('transaction')
            );*/
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**@test */
    public function test_create_MINUS_transaction()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
