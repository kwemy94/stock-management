<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Etablissement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $etablissement = Etablissement::where('email', 'admin@admin.com')->first();
        
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
        
        $users= array(
            array(
                'name' => "admin1",
            // 'username' => "admin",
            'sexe' => "F",
            'phone' => "675343434",
            'email' => "admin@admin.com",
            'cni' => "12345678",
            'etablissement_id' => $etablissement->id,
            'password' => Hash::make('admin-shell'),
            ),
            array(
                'name' => "collect1",
            // 'username' => "collect",
            'sexe' => "F",
            'phone' => "6753434",
            'email' => "collect@collect.com",
            'cni' => "1345678",
            'etablissement_id' => $etablissement->id,
            'password' => Hash::make('2s@Kollect'),
            ),
        );

        foreach ($users as $key => $user) {
            $exisUser = DB::table('users')->where('email', $user['email'])->first();

            if(!$exisUser){
                DB::table('users')->insert($user);
                $newUser = DB::table('users')->where('email', $user['email'])->first();
                
                $admin->users()->attach($newUser->id);
                
            }
        }

        
    }
}
