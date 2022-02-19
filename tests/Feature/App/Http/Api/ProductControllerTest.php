<?php

namespace Tests\Feature\App\Http\Api;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->seed();
    }
    /**
     * Test that a user should not create a product without name.
     *
     * @return void
     */

    public function test_that_user_can_not_create_product_without_name()
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $data = [
            // 'name' => 'Bush',
            'price' => 100,
        ];

        $response = $this->json('POST', route('admin.product.store'), $data);

        $response->assertJsonValidationErrors(['name']);

        $response->assertJson([
            "message" => "The name field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user should not create a product without price.
     *
     * @return void
     */

    public function test_that_user_can_not_create_product_without_price()
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $data = [
            'name' => 'Test Product',
            // 'price' => 100,
        ];

        $response = $this->json('POST', route('admin.product.store'), $data);

        $response->assertJsonValidationErrors(['price']);

        $response->assertJson([
            "message" => "The price field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user can create a product.
     *
     * @return void
     */

    public function test_that_user_can_create_product()
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $data = [
            'name' => 'Test Product',
            'price' => 100,
        ];

        $response = $this->json('POST', route('admin.product.store'), $data);

        $response->assertJsonValidationErrors(['price']);

        $response->assertJson([
            "message" => "The price field is required.",
        ]);

        $response->assertStatus(422);
    }


    /**
     * Test that a user should not create a product without beeing logged in as an admin.
     *
     * @return void
     */

    public function test_that_only_admin_create_product()
    {
        $data = [
            // 'name' => 'Bush',
            'price' => 100,
        ];

        $response = $this->json('POST', route('admin.product.store'), $data);

        $response->assertJson([
            "message" => "Unauthorized.",
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test that a products can be retrieved.
     *
     * @return void
     */

    public function test_that_user_can_retrieve_products()
    {
        $response = $this->json('POST', route('product.all'));

        $response->assertJson([
            "status" => true,
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test that a products can be retrieved.
     *
     * @return void
     */

    public function test_that_user_can_retrieve_single_product()
    {
        $product = new Product;

        $product->name = "Test product";
        $product->price = 100;
        $product->user_id = 1;
        $product->save();
        
        $response = $this->json('POST', route('product.show', $product->id));

        $response->assertJson([
            "status" => true,
        ]);

        $response->assertStatus(200);
    }

}