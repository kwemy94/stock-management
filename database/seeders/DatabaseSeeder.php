<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        /**
         * Todo: faire en sorte de la condition 
         * ci dessous s'exécute en front
         */
        if (1==1) { #Toute les migrations front
            $this->call(EtablissementSeeder::class);
            $this->call(RoleSeeder::class);
            $this->call(UserFrontEndSeeder::class);
        } else {
            $this->call(SettingSeeder::class);
        }
        
        
    }
}
