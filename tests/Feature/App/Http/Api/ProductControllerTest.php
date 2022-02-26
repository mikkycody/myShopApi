<?php

namespace Tests\Feature\App\Http\Api;

use App\Models\User;
use App\Models\RemovedItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Testing\Fluent\AssertableJson;


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

    public function test_that_user_should_not_create_product_without_name()
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

    public function test_that_user_should_not_create_product_without_price()
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
     * Test that only admin user can create a product.
     *
     * @return void
     */

    public function test_that__only_admin_user_can_create_product()
    {
        $user = User::find(1);
        Passport::actingAs($user);

        $data = [
            'name' => 'Test Product',
            'price' => 100,
        ];

        $response = $this->json('POST', route('admin.product.store'), $data);

        $response->assertStatus(201);
    }


    /**
     * Test that a user should not create a product without being logged in as an admin.
     *
     * @return void
     */

    public function test_that_normal_user_cannot_create_product()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            // 'name' => 'Bush',
            'price' => 100,
        ];

        $response = $this->json('POST', route('admin.product.store'), $data);

        $response->assertStatus(404);
    }

    /**
     * Test that a products can be retrieved.
     *
     * @return void
     */

    public function test_that_user_can_retrieve_products()
    {
        $response = $this->json('GET', route('product.all'));

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
        $response = $this->json('GET', route('product.show', 1));

        $response->assertJson([
            "status" => true,
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test that a products should exist.
     *
     * @return void
     */

    public function test_that_user_should_not_retrieve_a_non_existing_product()
    {
        $response = $this->json('GET', route('product.show', 100000));

        $response->assertJson([
            "message" => "Product not found.",
        ]);
        $response->assertStatus(400);
    }

    /**
     * Test that a user can not remove a product without product id.
     *
     * @return void
     */

    public function test_that_user_should_not_remove_a_product_without_product_id()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $response = $this->json('POST', route('product.remove'));

        $response->assertJson([
            "message" => "The product id field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user can not remove a product that does not exist.
     *
     * @return void
     */

    public function test_that_user_should_not_remove_a_product_that_does_not_exists()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            'product_id' => 100000,
        ];

        $response = $this->json('POST', route('product.remove'), $data);

        $response->assertJson([
            "message" => "No product found with this id.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user can remove a product.
     *
     * @return void
     */

    public function test_that_user_can_remove_a_product()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $data = [
            'product_id' => 1,
        ];
        $response = $this->json('POST', route('product.remove'), $data);

        $response->assertJson([
            "message" => "Product Removed Successfully.",
        ]);

        $this->assertDatabaseHas('removed_items', [
            'user_id' => 2,
            'product_id' => 1,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test that a user should not fetch removed products without being logged in as a sales rep.
     *
     * @return void
     */

    public function test_that_normal_user_should_not_fetch_removed_products()
    {
        $user = User::find(2);
        Passport::actingAs($user);

        $response = $this->json('GET', route('sales.products.removed'));

        $response->assertStatus(404);
    }

    /**
     * Test that sales rep can fetch removed products
     *
     * @return void
     */

    public function test_that_only_sales_rep_can_fetch_removed_products()
    {
        $user = User::find(3);
        Passport::actingAs($user);

        RemovedItem::create([
            'user_id' => $user->id,
            'product_id' => 1,
        ]);
        $response = $this->json('GET', route('sales.products.removed'));

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has(
                    'data.0.product',
                    fn ($json) =>
                    $json->where('id', 1)
                        ->etc()
                )
                    ->has(
                        'data.0.user',
                        fn ($json) =>
                        $json->where('id', $user->id)
                            ->etc()
                    )
                    ->etc()
            );
        $response->assertStatus(200);
    }
}
