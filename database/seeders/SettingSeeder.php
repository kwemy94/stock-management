<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate([
            'app_name' => 'T.B. - Stock',
            'devise' => '$',
            'phone' => '788900',
            'email' => 'admin@entreprise.com',
        ]);
    }
}
