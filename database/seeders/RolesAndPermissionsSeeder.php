<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $createUserPermission = Permission::create(['name' => 'create user']);
        $deleteUserPermission = Permission::create(['name' => 'delete user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($createUserPermission);
        $adminRole->givePermissionTo($deleteUserPermission);

        $managerRole->givePermissionTo($createUserPermission);
    }

}
