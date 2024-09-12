<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etablissements = array(
            array(
                'name' => "app-aministration-tech-briva",
                'email' => 'tigod2302@gmail.com',
                'status' => 1,
                'settings' => json_encode(array("db" => array('database' => 'admin_db_app', 'username' => 'root', 'password' => ''), 'momo' => '{}')),
            )
        );

        foreach ($etablissements as $key => $etablissement) {
            $existEts = DB::table('etablissements')->where('name', $etablissement['name'])->first();

            if(!$existEts){
                DB::table('etablissements')->insert($etablissement);
            }
        }
    }
}
