<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('Secret!password0')
        ]);

        $user->roles()->sync([1]);

        $users = User::factory(10)->create();

        $users->each(function ($user) { 
            $user->roles()->sync(rand(2,4)); 
        });
    }
}