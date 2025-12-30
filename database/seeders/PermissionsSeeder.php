<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // ======================
            // MODULE
            // ======================
            ['name' => 'manage pos', 'group' => 'module', 'guard_name' => 'web'],
            ['name' => 'manage sales', 'group' => 'module', 'guard_name' => 'web'],
            ['name' => 'manage purchase', 'group' => 'module', 'guard_name' => 'web'],
            // ======================
            // CLIENTS
            // ======================
            ['name' => 'list client', 'group' => 'clients', 'guard_name' => 'web'],
            ['name' => 'create client', 'group' => 'clients', 'guard_name' => 'web'],
            ['name' => 'update client', 'group' => 'clients', 'guard_name' => 'web'],
            ['name' => 'delete client', 'group' => 'clients', 'guard_name' => 'web'],

            // ======================
            // CATÉGORIES
            // ======================
            ['name' => 'create category', 'group' => 'categories', 'guard_name' => 'web'],
            ['name' => 'update category', 'group' => 'categories', 'guard_name' => 'web'],
            ['name' => 'delete category', 'group' => 'categories', 'guard_name' => 'web'],

            // ======================
            // FOURNISSEURS
            // ======================
            ['name' => 'create supplier', 'group' => 'suppliers', 'guard_name' => 'web'],
            ['name' => 'update supplier', 'group' => 'suppliers', 'guard_name' => 'web'],
            ['name' => 'delete supplier', 'group' => 'suppliers', 'guard_name' => 'web'],
            ['name' => 'list supplier', 'group' => 'suppliers', 'guard_name' => 'web'],

            // ======================
            // PRODUITS
            // ======================
            ['name' => 'create product', 'group' => 'products', 'guard_name' => 'web'],
            ['name' => 'update product', 'group' => 'products', 'guard_name' => 'web'],
            ['name' => 'delete product', 'group' => 'products', 'guard_name' => 'web'],
            ['name' => 'print qr code product', 'group' => 'products', 'guard_name' => 'web'],

            // ======================
            // UTILISATEURS
            // ======================
            ['name' => 'create user', 'group' => 'users', 'guard_name' => 'web'],
            ['name' => 'update user', 'group' => 'users', 'guard_name' => 'web'],
            ['name' => 'delete user', 'group' => 'users', 'guard_name' => 'web'],

            // ======================
            // ENTREPRISE / COMPANY
            // ======================
            ['name' => 'update company info', 'group' => 'company', 'guard_name' => 'web'],
            ['name' => 'manage point of sale', 'group' => 'company', 'guard_name' => 'web'],
            ['name' => 'view pos statistics', 'group' => 'company', 'guard_name' => 'web'],

            // ======================
            // VENTES
            // ======================
            ['name' => 'confirm sale invoice', 'group' => 'sales', 'guard_name' => 'web'],
            ['name' => 'update sale invoice', 'group' => 'sales', 'guard_name' => 'web'],
            ['name' => 'view sales report', 'group' => 'sales', 'guard_name' => 'web'],

            ['name' => 'convert proforma to command', 'group' => 'sales', 'guard_name' => 'web'],
            ['name' => 'create proforma', 'group' => 'sales', 'guard_name' => 'web'],

            ['name' => 'print command', 'group' => 'sales', 'guard_name' => 'web'],
            ['name' => 'view command list', 'group' => 'sales', 'guard_name' => 'web'],
            ['name' => 'view command details', 'group' => 'sales', 'guard_name' => 'web'],
            ['name' => 'create command', 'group' => 'sales', 'guard_name' => 'web'],

            // ======================
            // INVENTAIRE / STOCK
            // ======================
            ['name' => 'perform inventory', 'group' => 'inventory', 'guard_name' => 'web'],
            ['name' => 'view purchase report', 'group' => 'inventory', 'guard_name' => 'web'],
            ['name' => 'view stock movements', 'group' => 'inventory', 'guard_name' => 'web'],

            // ======================
            // COMMANDES & RÉCEPTIONS
            // ======================
            
            ['name' => 'view purchase orders', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'create purchase orders', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'update purchase order', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'confirm purchase order', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'delete purchase order', 'group' => 'orders', 'guard_name' => 'web'],
            
            // ['name' => 'create supplier reception', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'view reception notes', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'update reception note', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'create reception note', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'delete reception note', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'print reception note', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'confirm reception note', 'group' => 'orders', 'guard_name' => 'web'],
            ['name' => 'view reception note details', 'group' => 'orders', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['group' => $permission['group'], 'guard_name' => $permission['guard_name']]
            );
        }
    }
}
