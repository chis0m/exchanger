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
    // private $email;
    private $header;


    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = '/api/user';
        $this->createUser();
    }

    private function createUser()
    {
        $this->user = factory(User::class)->create([
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('test04'),
        ]);
    }

    /**
     * To test if user can register.
     *
     * @return void
     */
    public function testUserCanRegister()
    {
        $url = $this->baseUrl . "/register";
        $response = $this->post($url, ['first_name' => 'tester', 'last_name' => 'testee', 'email' => 'test3@test.com', 'password' => 'test04']);
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
    public function testToValidateRegistrationInputErrors()
    {
        $url = $this->baseUrl . "/register";
        $response = $this->post($url, ['first_name' => '', 'email' => '', 'password' => ''], ['Accept' => 'Application/json']);
        $response->assertStatus(422)->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'first_name' => [
                    'The first name field is required.'
                ],
                'last_name' => [
                    'The last name field is required.'
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
    public function testToValidatePasswordField()
    {
        $url = $this->baseUrl . "/register";
        $response = $this->post(
            $url,
            ['first_name' => 'testout', 'last_name' => 'testnow', 'email' => 'test22@test.com', 'password' => 'test'],
            ['Accept' => 'Application/json']
        );
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
    public function testUserCanLogin()
    {
        $this->actingAs($this->user);
        $url = $this->baseUrl . "/login";
        $response = $this->post($url, ['email' => 'test@test.com', 'password' => 'test04']);
        $response->assertStatus(202);
    }


    /**
     * Test to login validation.
     *
     * @return void
     */
    public function testLoginValidationErrors()
    {
        $url = $this->baseUrl . "/login";
        $response = $this->post($url, ['email' => '', 'password' => ''], ['Accept' => 'Application/json']);
        $response->assertStatus(422)->assertJson([
            'success' => false,
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
