<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitMeasureSeeder extends Seeder
{
    public function run()
    {
        $units = [
            ['name' => 'Pièce'],
            ['name' => 'Kg'],
            ['name' => 'Litre'],
            ['name' => 'Boîte'],
            ['name' => 'Paquet'],
        ];

        foreach ($units as $key => $unit) {
            $exisUnit = DB::table('units')->where('name', $unit['name'])->first();
            
            if(!$exisUnit){
                DB::table('units')->insert($unit);
            }
        }
    }
}
