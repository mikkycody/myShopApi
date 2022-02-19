<?php

namespace Tests\Unit\Database\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class UserSchemaTest extends TestCase
{
    use RefreshDatabase;
    public function test_that_users_schema_has_all_expected_columns()
    {
        $this->assertTrue(Schema::hasColumns('users', ['id', 'name', 'email', 'email_verified_at', 'password', 'access_token']), 1);
    }
}
