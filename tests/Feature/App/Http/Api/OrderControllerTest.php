<?php

namespace Tests\Feature\App\Http\Api;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->seed();
    }

    /**
     * Test that a user can create a cart.
     *
     * @return void
     */

    public function test_that_user_can_create_an_order()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $response = $this->json('POST', route('order.store'));

        $response->assertStatus(201);
    }


}
