<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class CartchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_carts_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('carts', ['id', 'user_id']), 1);
    }
}
