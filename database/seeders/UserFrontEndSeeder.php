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
        $etablissement = DB::table('etablissements')->where('email', 'tigod2302@gmail.com')->first();
        
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
                'name' => "admin19",
            // 'username' => "admin",
            'sexe' => "F",
            'phone' => "675343434",
            'email' => "tigod2302@gmail.com",
            'cni' => "12345678",
            'etablissement_id' => $etablissement->id,
            'password' => '$2y$12$Db/mbVUJO5ztblcK.fX39.Iki0snwHkotjRD26LTFQ/eAbJrY40LO',
            ),
            array(
                'name' => "admin-shell",
            // 'username' => "admin",
            'sexe' => "F",
            'phone' => "672517118",
            'email' => "grantshell@gmail.com",
            'cni' => "12347678",
            'etablissement_id' => $etablissement->id,
            'password' => '$2y$12$Db/mbVUJO5ztblcK.fX39.Iki0snwHkotjRD26LTFQ/eAbJrY40LO',
            ),
            array(
                'name' => "collect1",
            // 'username' => "collect",
            'sexe' => "F",
            'phone' => "6753434",
            'email' => "collect@collect.com",
            'cni' => "1345678",
            'etablissement_id' => $etablissement->id,
            'password' => '$2y$12$UHjJ2LRlS7WP2LWXohzQyOGjtkiOt4JgXPwefNIdFcvQIOOIHVcl2',
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
