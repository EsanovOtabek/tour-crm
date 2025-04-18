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
        // 1. Rollarni yaratish
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator']);
        $casserRole = Role::firstOrCreate(['name' => 'casser']);

        // 2. Permissionlarni yaratish
        $permissions = [
            'users.index',
            'users.create',
            'users.edit',
            'users.delete',

            'roles.index',
            'roles.store',

            'permissions.index',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            'roles.permissions.index',
            'roles.permissions.sync',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // 3. Admin - barcha permissionlarga ega
        $adminRole->syncPermissions(Permission::all());

        // 4. Operator - role va permission bilan bog‘liq amallardan tashqari permissionlar
        $operatorRole->syncPermissions([
            'users.index',
            'users.create',
            'users.edit',
            'users.delete',
        ]);

        // 5. Casser - cheklangan permissionlar (masalan, faqat ko‘rish va yangilash)
        $casserRole->syncPermissions([
            'users.index',
            'users.edit',
        ]);
    }
}
