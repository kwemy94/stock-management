<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payModes = [
            [
                'name' => "Espèce",
                'code' => "espece"
            ],
            [
                'name' => "Check",
                'code' => "bank"
            ],
            [
                'name' => "Paiement mobile",
                'code' => "momo"
            ],
        ];

        foreach ($payModes as $key => $mode) {
            $existMode = DB::table('payment_modes')->where('code', $mode['code'])->first();

            if (!$existMode) {
                DB::table('payment_modes')->insert($mode);
            }
        }
    }
}
