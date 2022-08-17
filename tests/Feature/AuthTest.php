<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_users_can_authenticate()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Secret!password0')
        ]);
        
        $response = $this->post('/api/auth/login', [
            "email" => $user->email,
	        "password" => "Secret!password0"
        ]);

        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'User login successfully.',
            'data' => [
                'token' => true,
                'name' => $user->name
            ]
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Secret!password0')
        ]);
        
        $response = $this->post('/api/auth/login', [
            "email" => $user->email,
	        "password" => "password"
        ]);

        $response->assertStatus(401)->assertJson([
            'success' => false,
            'message' => 'Unauthorised.',
            'errors' => true
        ]);
    }
}
