<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_users_can_get_users_list()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Secret!password0')
        ]);

        $role = Role::factory()->create([
            'name' => 'Administrator',
        ]);

        $user->roles()->sync([1]);

        $response_logout = $this->actingAs($user)->get('/api/users');

        $response_logout->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'data' => []
        ]); 
    }

    public function test_users_can_not_get_users_list_without_role_id_1()
    {
        $user = User::factory()->create([
            'password' => bcrypt('Secret!password0')
        ]);

        $role = Role::factory()->count(4)->create();

        $user->roles()->sync([3, 4]);

        $response_logout = $this->actingAs($user)->get('/api/users');

        $response_logout->assertStatus(403)->assertJson([
            'message' => 'Access denied'
        ]); 
    }
}
