<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if (!function_exists('generateProductBarcode')) {
    function generateProductBarcode($path = '/dashboard/produit')
    {
        $code = rand(555000, 699699);
        $barcode = QrCode::size(60)->generate($code);

        return [$code, $barcode];
    }
}


if (!function_exists('generateRandomPassword')) {
    function generateRandomPassword($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz$@_-%+ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;

    }
}


if (!function_exists('toggleDatabase')) {
    function toggleDatabase($isClientDatabase = true)
    {
        if ($isClientDatabase) {
            // $userRepository = new UserRepository(new User());

            $user = \Auth::user(); //
            // dd('test', $user);
            if ($user):
                // dd(session());
                // dd($user);
                $etablissement = DB::table('etablissements')->where('id', $user->etablissement_id)->first();
                // dd($etablissement);
                $settings = json_decode($etablissement->settings);


                config()->set('database.connections.mobility', [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => $settings->db->database,
                    'username' => $settings->db->username,
                    'password' => $settings->db->password,
                    'unix_socket' => env('DB_SOCKET', ''),
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                    'modes' => [
                        //'ONLY_FULL_GROUP_BY', // Disable this to allow grouping by one column
                        'STRICT_TRANS_TABLES',
                        'NO_ZERO_IN_DATE',
                        'NO_ZERO_DATE',
                        'ERROR_FOR_DIVISION_BY_ZERO',
                        //'NO_AUTO_CREATE_USER', // This has been deprecated and will throw an error in mysql v8
                        'NO_ENGINE_SUBSTITUTION',
                    ],
                ]);
                DB::purge('mobility');
                $connection = DB::connection('mobility');
                Config::set('database.default', $connection->getName());
            else:
                dd('test2');
                $connection = null;
            endif;
        } else {

            $connection = DB::connection('mysql');
            Config::set('database.default', 'mysql');

        }

        return $connection;
    }

}

if (!function_exists('toggleDatabaseById')) {
    function toggleDatabaseById($etablissementId)
    {
        toggleDatabase(false);
        $ets = DB::table('etablissements')->where('id', $etablissementId)->first();

        if ($ets):
            try {
                $settings = json_decode($ets->settings);

                config()->set('database.connections.client_db', [
                    'driver' => 'mysql',
                    'host' => env('DB_HOST', '127.0.0.1'),
                    'port' => env('DB_PORT', '3306'),
                    'database' => $settings->db->database,
                    'username' => $settings->db->username,
                    'password' => $settings->db->password,
                    'unix_socket' => env('DB_SOCKET', ''),
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'strict' => true,
                    'engine' => null,
                    'modes' => [
                        //'ONLY_FULL_GROUP_BY', // Disable this to allow grouping by one column
                        'STRICT_TRANS_TABLES',
                        'NO_ZERO_IN_DATE',
                        'NO_ZERO_DATE',
                        'ERROR_FOR_DIVISION_BY_ZERO',
                        //'NO_AUTO_CREATE_USER', // This has been deprecated and will throw an error in mysql v8
                        'NO_ENGINE_SUBSTITUTION',
                    ],
                ]);
                DB::purge('client_db');

                $connection = DB::connection('client_db');
                Config::set('database.default', $connection->getName());
            } catch (\Throwable $th) {
                dd($th);
                //throw $th;
            }
        else:
            $connection = null;

        endif;

        return $connection;
    }

}

if (!function_exists('errorManager')) {
    function errorManager($action, \Exception $e, $message = null)
    {
        if ($message) {
            DB::table('error_managers')->insert(['id' => \Str::random(30), 'action' => $action, 'message' => $message, 'created_at' => now()]);
        }
        DB::table('error_managers')->insert(['id' => \Str::random(30), 'action' => $action, 'message' => $e->getMessage(), 'line' => $e->getLine(), 'code' => $e->getCode(), 'created_at' => now()]);
    }
}

if (!function_exists('automationRecipe')) {
    function automationRecipe($inputs)
    {
        if ($inputs) {
            DB::table('recipes')->insert($inputs);
            return true;
        }
        return false;
    }
}


if (!function_exists('automationExpense')) {
    function automationExpense($inputs)
    {
        if ($inputs) {
            DB::table('expenses')->insert($inputs);
            return true;
        }
        return false;
    }
}

if (!function_exists('checkCompany')) {
    function checkCompany()
    {
        toggleDatabase(false);
        $user = Auth::user();
        $company = DB::table('etablissements')->where('email', 'tigod2302@gmail.com')->first();

        return $user->etablissement_id == $company->id && $user->email == "tigod2302@gmail.com";
    }
}

if (!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber($_table, $init = 'FV', $client_db = true)
    {
        $today = Carbon::now();
        $dateCode = $today->format('y-m-d');

        // toggleDatabase($client_db);
        # Récupérer la dernière facture du jour
        $lastInvoice = DB::table($_table)
            ->whereDate('created_at', $today->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInvoice) {
            # Extraire la séquence de la dernière facture
            $lastNumber = intval(substr($lastInvoice->invoice_number, -3));
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001'; # première facture de la journée
        }

        return "{$init}-{$dateCode}-{$nextNumber}";
    }
}

if(!function_exists('getCompanyInfo')){
    function getCompanyInfo(){
        $setting = DB::table('settings')->first();
        
        return $setting;

    }
}
