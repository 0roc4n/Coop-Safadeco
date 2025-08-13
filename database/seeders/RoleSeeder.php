<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Role',
            'Members',
            'Board of Directors',
            'Officers',
            'Staff',
            'Committees',
        ];

        foreach ($roles as $roleName) {
            Role::create([
                'name' => $roleName,
                // 'description' => '', // If you add a description field later
            ]);
        }
    }
}
