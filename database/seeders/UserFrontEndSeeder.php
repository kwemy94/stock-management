<?php

namespace Database\Seeders;

use App\Models\Etablissement;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserFrontEndSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $etablissement = Etablissement::orderBy('id', 'desc')->first();
        
        Role::create([
            'name' => 'client',
            'description' => 'utilisateur client',
        ]);
       $admin = Role::create([
            'name' => 'root',
            'description' => 'super admin',
        ]);
        Role::create([
            'name' => 'collector',
            'description' => 'utilisateur collecteur',
        ]);

        $user1 = User::create([
            'name' => "admin1",
            // 'username' => "admin",
            'sexe' => "F",
            'phone' => "675343434",
            'email' => "admin@seeder.com",
            'cni' => "12345678",
            'etablissement_id' => $etablissement->id,
            'password' => Hash::make('2s@Kollect'),
        ]);
        
        $admin->users()->attach($user1->id);

        $user2 = User::create([
            'name' => "collect1",
            // 'username' => "collect",
            'sexe' => "F",
            'phone' => "6753434",
            'email' => "collect@collect.com",
            'cni' => "1345678",
            'etablissement_id' => $etablissement->id,
            'password' => Hash::make('2s@Kollect'),
        ]);

        $admin->users()->attach($user2->id);
    }
}
