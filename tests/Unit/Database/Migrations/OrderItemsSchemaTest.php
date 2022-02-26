<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class OrderItemsSchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_order_items_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('order_items', ['id', 'order_id', 'product_id', 'quantity']), 1);
    }
}
