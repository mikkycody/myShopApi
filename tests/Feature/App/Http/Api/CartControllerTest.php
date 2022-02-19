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

    public function test_that_user_can_create_a_cart()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $response = $this->json('POST', route('cart.store'));

        $response->assertStatus(201);
    }

    /**
     * Test that a non logged in user should not create a cart.
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

    /**
     * Test that a product can be added to cart.
     *
     * @return void
     */

    public function test_that_a_product_can_be_added_to_cart()
    {
        $user = User::find(2);
        Passport::actingAs($user);
        $cart = Cart::create(['user_id' => $user->id]);

        $data = [
            'cart_id' => $cart->id,
            'product_id' => 1,
        ];

        $response = $this->json('POST', route('cart.add'), $data);

        $response->assertStatus(200);
    }

    /**
     * Test that a product should be added to cart.
     *
     * @return void
     */

    public function test_that_a_product_should_be_added_to_cart()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $cart = Cart::create(['user_id' => $user->id]);

        $data = [
            'cart_id' => $cart->id,
            // 'product_id' => 1,
        ];

        $response = $this->json('POST', route('cart.add'), $data);

        $response->assertJsonValidationErrors(['product_id']);

        $response->assertJson([
            "message" => "The product id field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a product added should exist.
     *
     * @return void
     */

    public function test_that_a_product_added_should_exists()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $cart = Cart::create(['user_id' => $user->id]);

        $data = [
            'cart_id' => $cart->id,
            'product_id' => 1000000,
        ];

        $response = $this->json('POST', route('cart.add'), $data);

        $response->assertJson([
            "message" => "Product not found.",
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test that cart should exist.
     *
     * @return void
     */

    public function test_that_cart_should_exist()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            'cart_id' => 10000000,
            'product_id' => 1,
        ];

        $response = $this->json('POST', route('cart.add'), $data);

        $response->assertJson([
            "message" => "Cart not found.",
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test that a product removed should exist in cart.
     *
     * @return void
     */

    public function test_that_a_product_removed_should_exist_in_cart()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $cart = Cart::create(['user_id' => $user->id]);

        $data = [
            'cart_id' => $cart->id,
            'product_id' => 1000000,
        ];

        $response = $this->json('POST', route('cart.remove'), $data);

        $response->assertJson([
            "message" => "Product not found.",
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test that a product removed should exist in cart.
     *
     * @return void
     */

    public function test_that_a_product_can_be_removed_from_cart()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $cart = Cart::create(['user_id' => $user->id]);
        $cart->products()->attach(1);

        $data = [
            'cart_id' => $cart->id,
            'product_id' => 1,
        ];

        $response = $this->json('POST', route('cart.remove'), $data);

        $response->assertStatus(200);
    }

}
