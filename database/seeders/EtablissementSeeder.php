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
                'email' => 'tibriva2302@gmail.com',
                'status' => 1,
                'settings' => json_encode(array("db" => array('database' => 'audien6989_db_gt2', 'username' => 'audien6989_gt2', 'password' => 'P4?2D7dv2rnf'), 'momo' => '{}')),
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
