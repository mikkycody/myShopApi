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
     * Test that a user should not signup without name.
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

        $response = $this->json('POST', route('auth.signup'), $data);

        $response->assertJsonValidationErrors(['name']);

        $response->assertJson([
            "message" => "The name field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user should not signup without password.
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

        $response = $this->json('POST', route('auth.signup'), $data);

        $response->assertJsonValidationErrors(['password']);

        $response->assertJson([
            "message" => "The password field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user should not signup without passwordn confirmation match.
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

        $response = $this->json('POST', route('auth.signup'), $data);

        $response->assertJsonValidationErrors(['password']);

        $response->assertJson([
            "message" => "The password confirmation does not match.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user should not signup without email.
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

        $response = $this->json('POST', route('auth.signup'), $data);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJson([
            "message" => "The email field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user should not signup with an invalid email.
     *
     * @return void
     */

    public function test_that_user_can_not_sign_up_with_invalid_email()
    {
        $data = [
            'name' => 'Bush',
            'email' => "something@invalid",
            'password' => 'somethingsomething',
            'password_confirmation' => 'somethingsomething',
        ];

        $response = $this->json('POST', route('auth.signup'), $data);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJson([
            "message" => "The email must be a valid email address.",
        ]);

        $response->assertStatus(422);
    }


    /**
     * Test that a user can signup.
     *
     * @return void
     */
    public function test_that_user_can_sign_up()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => 'Bush',
            'password' => 'somethingsomething',
            'password_confirmation' => 'somethingsomething',
            'email' => 'mikkycody@gmail.com',
        ];

        $response = $this->json('POST', route('auth.signup'), $data);

        $response->assertStatus(201);
    }

    /**
     * Test that a user can not not signin with no email.
     *
     * @return void
     */
    public function test_that_user_can_not_sign_in_with_no_email()
    {
        $data = [
            // 'email' => 'Bush@gmail.com',
            'password' => 'somethingsomething'
        ];

        $response = $this->json('POST', route('auth.login'), $data);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJson([
            "message" => "The email field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user can not not signin with an invalid email.
     *
     * @return void
     */
    public function test_that_user_can_not_sign_in_with_invalid_email()
    {
        $data = [
            'email' => "something@invalid",
            'password' => 'somethingsomething'
        ];

        $response = $this->json('POST', route('auth.login'), $data);

        $response->assertJsonValidationErrors(['email']);

        $response->assertJson([
            "message" => "The email must be a valid email address.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user can not not signin with no password.
     *
     * @return void
     */
    public function test_that_user_can_not_sign_in_with_no_password()
    {
        $data = [
            'email' => 'Bush@gmail.com',
            // 'password' => 'somethingsomething'
        ];

        $response = $this->json('POST', route('auth.login'), $data);

        $response->assertJsonValidationErrors(['password']);

        $response->assertJson([
            "message" => "The password field is required.",
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test that a user can not not signin with wrong credentials.
     *
     * @return void
     */
    public function test_that_user_can_not_sign_in_with_wrong_credentials()
    {

        $data = [
            //send wrong login details
            'email' => 'Bush@gmail.com',
            'password' => 'thisiswrong123'
        ];

        $response = $this->json('POST', route('auth.login'), $data);

        $response->assertStatus(401);
    }

    /**
     * Test that a user can signin.
     *
     * @return void
     */
    public function test_that_user_can_sign_in()
    {

        $this->withoutExceptionHandling();

        \Illuminate\Support\Facades\Artisan::call('passport:install');

        $user = User::factory()->create();

        $response = $this->json('POST', route('auth.login'), ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(200);
    }

    /**
     * Test that a user can logout.
     *
     * @return void
     */
    public function test_that_user_can_logout()
    {

        $this->withoutExceptionHandling();

        \Illuminate\Support\Facades\Artisan::call('passport:install');

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->json('GET', route('auth.logout'), $user->toArray());

        $response->assertStatus(200);
    }
}
