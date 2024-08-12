<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login_with_incorrect_credentials()
    {

        $response = $this->postJson('/api/login', [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();

        $response->assertStatus(401);


        $response->assertJson([
            'status' => 'error',
            'message' => 'Invalid username or password. Please try again',
        ]);
    }

    public function test_login_with_correct_credential(){
        $response = $this->postJson('/api/login', [
            'username' => 'admin',
            'password' => 'pasti bisa',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'token',
                'admin' => [
                    'id',
                    'username',
                    'phone',
                    'email',
                    'name'
                ],
            ],
        ]);
        $this->assertAuthenticated();

        $response->assertJson([
            'status' => 'success',
            'message' => 'Login successful',
        ]);
    }


    public function test_user_can_logout()
    {

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;


        $response = $this->withHeaders(
            [
                'Authorization' => 'Bearer '.$token
            ]
        )->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Successfully logged out!'
                 ]);
    }

}
