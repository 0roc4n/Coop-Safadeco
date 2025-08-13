<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Privilege;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            if (strtolower($role->name) === 'role' || strtolower($role->name) === 'admin') {
                Privilege::create([
                    'can_read' => true,
                    'can_update' => true,
                    'can_add' => true,
                    'can_delete' => true,
                    'role_id' => $role->id,
                ]);
            } else {
                Privilege::create([
                    'can_read' => false,
                    'can_update' => false,
                    'can_add' => false,
                    'can_delete' => false,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
