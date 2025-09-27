<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Alimentation', 'description' => 'Produits alimentaires'],
            ['name' => 'Boissons', 'description' => 'Jus, eau, sodas'],
            ['name' => 'Électronique', 'description' => 'Appareils électroniques'],
            ['name' => 'Maison', 'description' => 'Produits pour la maison'],
            ['name' => 'Hygiène', 'description' => 'Produits de soins et nettoyage'],
        ];

        
        foreach ($categories as $key => $category) {
            $exisCat = DB::table('categories')->where('name', $category['name'])->first();
            
            if(!$exisCat){
                DB::table('categories')->insert($category);
            }
        }
    }
}
