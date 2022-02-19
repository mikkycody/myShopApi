<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class CartProductSchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_cart_product_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('cart_product', ['id', 'cart_id', 'product_id', 'deleted_at']), 1);
    }
}
