<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Permissions
        $permStock = Permission::firstOrCreate(['name' => 'manage stock']);
        $permSales = Permission::firstOrCreate(['name' => 'manage sales']);
        $permPOS = Permission::firstOrCreate(['name' => 'manage pos']);

        # Rôles + permissions
        $roles = [
            'super-admin' => [$permStock, $permSales, $permPOS],
            'admin' => [$permStock, $permSales],
            'manager' => [$permStock],
            'caissier' => [$permPOS],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            # Synchronise proprement les permissions
            $role->syncPermissions($permissions);
        }
    }
}
