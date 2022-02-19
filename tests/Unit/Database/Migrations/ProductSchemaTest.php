<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class ProductSchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_products_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('products', ['id', 'name', 'price', 'user_id']), 1);
    }
}
