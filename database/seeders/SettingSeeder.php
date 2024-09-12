<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = array(
            array(
                'app_name' => 'T.B. - Stock',
                'devise' => '$',
                'phone' => '788900',
                'email' => 'admin@entreprise.com',
            ),
        );


        foreach ($configs as $key => $conf) {
            $existConfig = DB::table('settings')->where('phone', $conf['phone'])->first();

            if (!$existConfig) {
                DB::table('settings')->insert($conf);
            }
        }
    }
}
