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
    public function test_create_transaction_since_user_not_participant()
    {
        $user1 = User::factory()->create([
            'isAdmin' => 0,
            'phone_numbre' => '0654841235'
        ]);
        $admin = User::factory()->create();

        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $response = $this->actingAs($user1)->postJson('/api/v1/entreprise/' . $entreprise->id . '/transaction', [
            'user_id' => $user1->id,
            'entreprise_id' => $entreprise->id,
            'type' => 'ADD',
            'amount' => 150.00,
        ]);


        $response->assertStatus(403)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
            );

    }

    /**@test */
    public function test_create_transaction_type_of_add()
    {
        $admin = User::factory()->create();

        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $admin->companies()->attach($entreprise->id);

        $response = $this->actingAs($admin)->postJson('/api/v1/entreprise/' . $entreprise->id . '/transaction', [
            'user_id' => $admin->id,
            'entreprise_id' => $entreprise->id,
            'type' => 'ADD',
            'amount' => 150.00,
        ]);


        $response->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
                     ->has('transaction')
            );

        $entreprise_after_transaction = Entreprise::find($entreprise->id);

        $this->assertEquals(150.00, $entreprise_after_transaction->amount_entre);

    }

    /**@test */
    public function test_create_transaction_type_of_minus_and_amount_entre_less_than_0_or_the_amount()
    {
        $admin = User::factory()->create();

        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $admin->companies()->attach($entreprise->id);

        $response = $this->actingAs($admin)->postJson('/api/v1/entreprise/' . $entreprise->id . '/transaction', [
            'user_id' => $admin->id,
            'entreprise_id' => $entreprise->id,
            'type' => 'MINUS',
            'amount' => 150.00,
        ]);


        $response->assertStatus(403)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
            );
    }

    /**@test */
    public function test_create_transaction_type_of_minus()
    {
        $admin = User::factory()->create();

        $entreprise = Entreprise::factory()->create([
            'owner_id' => $admin->id
        ]);

        $admin->companies()->attach($entreprise->id);
        
        $this->actingAs($admin)->postJson('/api/v1/entreprise/' . $entreprise->id . '/transaction', [
            'user_id' => $admin->id,
            'entreprise_id' => $entreprise->id,
            'type' => 'ADD',
            'amount' => 150.00,
        ]);

        $response = $this->actingAs($admin)->postJson('/api/v1/entreprise/' . $entreprise->id . '/transaction', [
            'user_id' => $admin->id,
            'entreprise_id' => $entreprise->id,
            'type' => 'MINUS',
            'amount' => 150.00,
        ]);


        $response->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('message')
                     ->has('transaction')
            );

        $entreprise_after_transaction = Entreprise::find($entreprise->id);
  
        $this->assertEquals(0,00, $entreprise_after_transaction->amount_entre);
        $this->assertEquals(150.00, $entreprise_after_transaction->amount_out);

    }
}
