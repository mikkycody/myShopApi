<?php

namespace Tests\Feature\App\Http\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;

class CarttControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test that a user can create a cart.
     *
     * @return void
     */

    public function test_that_user_can__create_a_cart()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $response = $this->json('POST', route('cart.store'));

        $response->assertStatus(201);
    }

    /**
     * Test that a no logged in user should not create a cart.
     *
     * @return void
     */

    public function test_that_a_non_logged_in_user_should_not_create_a_cart()
    {
        $response = $this->json('POST', route('cart.store'));

        $response->assertJson([
            "message" => "Unauthenticated.",
        ]);

        $response->assertStatus(401);
    }
}
