<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DivisionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_fetch_divisions_when_authenticated()
    {
        $user = User::firstOrCreate(
            ['username' => 'admin'],
            ['password' => Hash::make('pasti bisa')]
        );
        $token = $user->createToken('Test Token')->plainTextToken;


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/divisions?per_page=5');


        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'divisions' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
            'pagination' => [
                'total',
                'per_page',
                'current_page',
                'last_page',
                'next_page_url',
                'prev_page_url',
                'last_page_url',
                'first_page_url'
            ],
        ]);
        $response->assertJsonFragment(['status' => 'success']);
    }


    public function test_not_authenticate(){
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . "wrong token",
        ])->getJson('/api/divisions?per_page=5');
        $this->assertGuest();
    }
}
