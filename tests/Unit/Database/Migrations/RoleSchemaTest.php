<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class RoleSchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_roles_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('roles', ['id', 'name']), 1);
    }
}
