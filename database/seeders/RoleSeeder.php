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
        // Créer des permissions
        $permStock = Permission::create(['name' => 'manage stock']);
        $permSales = Permission::create(['name' => 'manage sales']);
        $permPOS = Permission::create(['name' => 'manage pos']);

        // Créer des rôles
        if (!Role::where('name', 'super-admin')->exists()) {
            $roleSuperAdmin = Role::create(['name' => 'super-admin']);
            $roleSuperAdmin->givePermissionTo([$permStock, $permSales]);
        }

        if (!Role::where('name', 'admin')->exists()) {
            $roleAdmin = Role::create(['name' => 'admin']);
            $roleAdmin->givePermissionTo([$permStock, $permSales]);
        }
        
        if (!Role::where('name', 'manager')->exists()) {
           $roleManager = Role::create(['name' => 'manager']);
              $roleManager->givePermissionTo($permStock);
        }

        if (!Role::where('name', 'caissier')->exists()) {
            $roleCaissier = Role::create(['name' => 'caissier']);
            $roleCaissier->givePermissionTo([$permPOS]);
        }

    }
}
