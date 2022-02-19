<?php

namespace Tests\Feature\App\Http\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test taht a user should not signup without name.
     *
     * @return void
     */

    public function test_that_user_can_not_sign_up_with_no_name()
    {
        $data = [
            // 'name' => 'Bush',
            'password' => 'somethingsomething',
            'password_confirmation' => 'somethingsomething',
            'email' => "mikky@gmail.com"
            //missing name input
        ];

        $response = $this->json('POST', route('signup'), $data);

        $response->assertJsonValidationErrors(['name']);

        $response->assertJson([
            "message" => "The given data was invalid.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test taht a user should not signup without password.
     *
     * @return void
     */

    public function test_that_user_can_not_sign_up_with_no_password()
    {
        $data = [
            'name' => 'Bush',
            // 'password' => 'somethingsomething',
            'password_confirmation' => 'somethingsomething',
            'email' => "bush@gmail.com"

            //missing password input
        ];

        $response = $this->json('POST', route('signup'), $data);

        $response->assertJsonValidationErrors(['password']);

        $response->assertJson([
            "message" => "The given data was invalid.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test taht a user should not signup without passwordn confirmation match.
     *
     * @return void
     */

    public function test_that_user_can_not_sign_up_with_no_password_confirmation_match()
    {
        $data = [
            'name' => 'Bush',
            'password' => 'somethingsomethingdifferent',
            'password_confirmation' => 'somethingsomething',
            'email' => "bush@gmail.com"

            // password mismatch
        ];

        $response = $this->json('POST', route('signup'), $data);

        $response->assertJsonValidationErrors(['password']);

        $response->assertJson([
            "message" => "The given data was invalid.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test taht a user should not signup without email.
     *
     * @return void
     */

    public function test_that_user_can_not_sign_up_with_no_email()
    {
        $data = [
            'name' => 'Bush',
            'password' => 'somethingsomething',
            'password_confirmation' => 'somethingsomething'
            // missing email input
        ];

        $response = $this->json('POST', route('signup'), $data);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJson([
            "message" => "The given data was invalid.",
        ]);

        $response->assertStatus(422);
    }


    public function test_that_user_can_sign_up()
    {
        $data = [
            'name' => 'Bush',
            'password' => 'somethingsomething',
            'password_confirmation' => 'somethingsomething',
            'email' => 'mikkycody@gmail.com',
        ];

        $response = $this->json('POST', route('signup'), $data);

        $response->assertStatus(201);
    }

    public function test_that_user_can_not_sign_in_with_no_email()
    {
        $data = [
            // 'email' => 'Bush@gmail.com',
            'password' => 'somethingsomething'
        ];

        $response = $this->json('POST', route('login'), $data);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJson([
            "message" => "The given data was invalid.",
        ]);

        $response->assertStatus(422);
    }

    public function test_that_user_can_not_sign_in_with_no_password()
    {
        $data = [
            'email' => 'Bush@gmail.com',
            // 'password' => 'somethingsomething'
        ];

        $response = $this->json('POST', route('login'), $data);

        $response->assertJsonValidationErrors(['password']);

        $response->assertJson([
            "message" => "The given data was invalid.",
        ]);

        $response->assertStatus(422);
    }

    public function test_that_user_can_not_sign_in_with_wrong_credentials()
    {

        $data = [
            //send wrong login details
            'email' => 'Bush@gmail.com',
            'password' => 'thisiswrong123'
        ];

        $response = $this->json('POST', route('login'), $data);

        $response->assertStatus(401);
    }

    public function test_that_user_can_sign_in()
    {

        $this->withoutExceptionHandling();

        \Artisan::call('passport:install');

        $user = User::factory()->create();

        $response = $this->json('POST', route('login'), ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(200);
    }

    public function test_that_user_can_logout()
    {

        $this->withoutExceptionHandling();

        \Artisan::call('passport:install');

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->json('GET', route('logout'), $user->toArray());

        $response->assertStatus(200);
    }
}
