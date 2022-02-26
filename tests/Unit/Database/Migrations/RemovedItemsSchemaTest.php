<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class RemovedItemsSchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_removed_items_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('removed_items', ['id', 'product_id']), 1);
    }
}
