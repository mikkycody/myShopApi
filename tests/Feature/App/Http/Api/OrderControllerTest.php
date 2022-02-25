<?php

namespace Tests\Feature\App\Http\Api;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->seed();
    }

    /**
     * Test that a user can create an order.
     *
     * @return void
     */

    public function test_that_user_can_create_an_order()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $product = Product::create([
            'user_id' => 1,
            'name' => 'Test',
            'price' => 100,
        ]);
        $data = [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 1,
                ]
            ]
        ];

        $response = $this->json('POST', route('order.store'), $data);

        $response->assertStatus(201);
    }

    /**
     * Test that a user should be logged in to create an order.
     *
     * @return void
     */

    public function test_that_a_user_should_be_logged_in_to_create_an_order()
    {
        $product = Product::create([
            'user_id' => 1,
            'name' => 'Test',
            'price' => 100,
        ]);
        $data = [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 1,
                ]
            ]
        ];

        $response = $this->json('POST', route('order.store'), $data);

        $response->assertJson([
            "message" => "Unauthenticated.",
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test that a user should not create an order without products.
     *
     * @return void
     */

    public function test_that_a_user_should_not_create_an_order_without_products()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $response = $this->json('POST', route('order.store'));

        $response->assertJson([
            "message" => "The products field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user order products should be an array.
     *
     * @return void
     */

    public function test_that_products_should_be_an_array()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            'products' => 1
        ];
        $response = $this->json('POST', route('order.store'), $data);

        $response->assertJson([
            "message" => "The products must be an array.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user order products should be an array that contains id.
     *
     * @return void
     */

    public function test_that_products_should_be_an_array_that_contains_id()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            'products' => [
                ['quantity' => 1]
            ]
        ];
        $response = $this->json('POST', route('order.store'), $data);

        $response->assertJson([
            "message" => "The product id is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user order products should be an array that contains a product id that exists.
     *
     * @return void
     */

    public function test_that_products_should_be_an_array_that_contains_a_product_id_that_exists()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            'products' => [
                ['id' => 1000000, 'quantity' => 1]
            ]
        ];
        $response = $this->json('POST', route('order.store'), $data);

        $response->assertJson([
            "message" => "No product found with this id.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user order products should be an array that contains id.
     *
     * @return void
     */

    public function test_that_products_should_be_an_array_that_contains_quantity()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            'products' => [
                ['id' => 1]
            ]
        ];
        $response = $this->json('POST', route('order.store'), $data);

        $response->assertJson([
            "message" => "The product quantity is required.",
        ]);

        $response->assertStatus(422);
    }
}
