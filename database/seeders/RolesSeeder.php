<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Administrator',
            'Author',
            'Editor',
            'Subscriber'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
