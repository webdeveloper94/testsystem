<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'manage tests']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view results']);
        Permission::create(['name' => 'take tests']);

        // Assign permissions to admin role
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo([
            'manage tests',
            'manage users',
            'view results',
            'take tests'
        ]);

        // Assign permissions to user role
        $userRole = Role::findByName('user');
        $userRole->givePermissionTo([
            'take tests'
        ]);
    }
}
