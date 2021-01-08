<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $baseUrl;
    private $user;


    public function setUp() :void
    {
        parent::setUp();
        $this->baseUrl = '/api/user';
        $this->create_user();
    }

    private function create_user(){
        $this->user = factory(User::class)->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('test'),
        ]);
    }

    /**
     * To test if user can register.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $url = $this->baseUrl."/register";
        $response = $this->post($url, ['name' => 'test1', 'email' => 'test1@test.com', 'password' => 'test04']);
        $response->assertStatus(201)->assertJson([
            'success' => true,
            'message' => 'Registration Successful',
            'data' => [
                'token_type' => 'bearer',
            ]
        ]);
    }

    /**
     * Test to validate registration form errors.
     *
     * @return void
     */
    public function test_to_validate_registration_input_errors()
    {
        $url = $this->baseUrl."/register";
        $response = $this->post($url, ['name' => '', 'email' => '', 'password' => ''], ['Accept' => 'Application/json']);
        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => [
                    'The name field is required.'
                ],
                'email' => [
                    'The email field is required.'
                ],
                'password' => [
                    'The password field is required.'
                ]
            ]
        ]);
    }

    /**
     * Test to validate password field.
     *
     * @return void
     */
    public function test_to_validate_password_field()
    {
        $url = $this->baseUrl."/register";
        $response = $this->post($url, ['name' => 'test2', 'email' => 'test22@test.com', 'password' => 'test'], ['Accept' => 'Application/json']);
        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'password' => [
                    'The password must be at least 6 characters.'
                ]
            ]
        ]);
    }

    /**
     * To test if user can login.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $url = $this->baseUrl."/login";
        $response = $this->post($url, ['email' => 'test@test.com', 'password' => 'test']);
        $response->assertStatus(202);
    }


    /**
     * Test to login validation.
     *
     * @return void
     */
    public function test_login_validation_errors()
    {
        $url = $this->baseUrl."/login";
        $response = $this->post($url, ['email' => '', 'password' => ''], ['Accept' => 'Application/json']);
        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    'The email field is required.'
                ],
                'password' => [
                    'The password field is required.'
                ]
            ]
        ]);
    }

}
