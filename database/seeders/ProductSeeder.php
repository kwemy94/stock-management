<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = DB::table('categories')->pluck('id')->toArray();
        $units = DB::table('units')->pluck('id')->toArray();

        $productNames = [
            // 🥩 Viandes & produits animaux
            "Lapin", "Poulet entier", "Poulet découpé", "Bœuf haché", "Côte de bœuf", "Viande de mouton",
            "Poisson fumé", "Poisson salé", "Poisson séché", "Crevettes séchées", "Hareng fumé",
            "Thon en boîte", "Sardine en boîte", "Maquereau en boîte", "Corned beef", "Œufs de poule", "Œufs de caille",

            // 🥦 Légumes & racines
            "Manioc frais", "Bâton de manioc", "Bâton de manioc sec", "Bobolo", "Plantain vert", "Plantain mûr",
            "Patate douce", "Igname blanc", "Igname jaune", "Taro", "Macabo", "Betterave rouge",
            "Chou pommé", "Chou frisé", "Carotte", "Tomate fraîche", "Oignon rouge", "Oignon blanc",
            "Ail", "Gingembre frais", "Piment rouge", "Piment vert",

            // 🥛 Produits laitiers
            "Lait en poudre (sachet)", "Lait en poudre (boîte)", "Lait concentré sucré", "Lait concentré non sucré",
            "Lait stérilisé", "Yaourt nature", "Yaourt sucré", "Yaourt à boire", "Fromage fondu", "Beurre doux", "Beurre salé",

            // 🥫 Conserves & sauces
            "Tomates concentrées", "Sauce tomate en boîte", "Purée de tomate", "Mayonnaise en sachet", "Mayonnaise en pot",
            "Moutarde en pot", "Moutarde en sachet", "Ketchup", "Haricots rouges en boîte", "Petits pois en boîte",
            "Maïs doux en boîte", "Champignons en boîte", "Pois chiches en boîte",

            // 🧂 Condiments & épices
            "Sel iodé", "Sel gemme", "Poivre noir", "Poivre blanc", "Curry", "Paprika", "Muscade",
            "Clous de girofle", "Basilic séché", "Feuilles de laurier", "Persil séché",
            "Cube Maggi bœuf", "Cube Maggi poulet", "Cube Jumbo", "Huile rouge", "Huile raffinée",
            "Huile d’arachide", "Huile de soja", "Vinaigre blanc", "Vinaigre de vin",

            // 🥤 Boissons
            "Jus d’orange", "Jus d’ananas", "Jus de mangue", "Jus de goyave", "Jus de bissap",
            "Eau minérale", "Eau gazeuse", "Soda cola", "Soda citron", "Malt local", "Bière locale",
            "Bière importée", "Vin rouge", "Vin blanc", "Vin de palme",

            // 🌾 Céréales & farines
            "Riz parfumé", "Riz étuvé", "Riz local", "Semoule de blé", "Farine de manioc (gari blanc)",
            "Gari jaune", "Farine de maïs", "Farine de blé", "Couscous de manioc", "Couscous de maïs",
            "Couscous de blé", "Avoine", "Flocons de maïs",

            // 🍌 Fruits
            "Mangue", "Papaye", "Orange", "Mandarine", "Banane douce", "Ananas",
            "Avocat", "Citron", "Pastèque", "Corossol", "Fruit de la passion", "Grenade",

            // 🍬 Sucreries
            "Sucre en morceaux", "Sucre en poudre", "Chocolat en poudre", "Cacao brut",
            "Biscuit sec", "Biscuit fourré", "Bonbons locaux", "Caramel mou", "Chocolat tablette",

            // 🧼 Divers
            "Savon de ménage", "Savon antiseptique", "Savon liquide", "Lessive en poudre",
            "Lessive liquide", "Détergent multi-usage", "Papier hygiénique", "Serviettes hygiéniques",
            "Allumettes", "Bougies", "Charbon de bois", "Bois de chauffe"
        ];

        $products = [];
        $count = 0;

        foreach ($productNames as $baseName) {
            // Générer 2 variantes max par produit jusqu’à atteindre 150
            $variants = rand(1, 2);
            for ($i = 1; $i <= $variants; $i++) {
                if ($count >= 150) break 2;

                $name = $baseName ;
                $products[] = [
                    'category_id'    => $categories[array_rand($categories)],
                    'unit_id'        => $units[array_rand($units)],
                    'product_name'   => $name,
                    'unit_price'     => rand(500, 5000),
                    'sale_price'     => rand(600, 7000),
                    'stock_quantity' => rand(5, 200),
                    'stock_alert'    => rand(2, 20),
                    'code'           => strtoupper(Str::random(8)),
                    'barcode'        => 'BAR' . str_pad($count + 1, 10, '0', STR_PAD_LEFT),
                    'product_image'  => null,
                    'description'    => "Produit africain - $baseName",
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
                $count++;
            }
        }
        // dd($products);

        foreach ($products as $key => $product) {
            $exisProduct = DB::table('products')->where('product_name', $product['product_name'])->first();
            
            if(!$exisProduct){
                DB::table('products')->insert($product);
            }
        }
    }
}
