<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class OrderSchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_orders_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('orders', ['id', 'cart_id']), 1);
    }
}
