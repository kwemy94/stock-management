<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BackendDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        # Tous mes seeds backends ici
        $this->call([
            SettingSeeder::class,
            PaymentModeSeeder::class,
            CategorySeeder::class,
            UnitMeasureSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
