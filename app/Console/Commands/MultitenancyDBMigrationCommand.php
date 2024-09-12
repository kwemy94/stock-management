<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\Etablissement\EtablissementRepository;

class MultitenancyDBMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:backend_db {path} {--artisanPath= : The absolute path to project root folder} {--targetDomain= : The specific domain to handle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command de migration de la base de données backend (path: chemin relatif vers le repertoire des migrations backend)';

    protected $etablissementRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EtablissementRepository $etablissementRepository)
    {
        parent::__construct();
        $this->etablissementRepository = $etablissementRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $etsEnCoursActivations = $this->etablissementRepository->getAll(0);
        foreach ($etsEnCoursActivations as $ets) {
            $setting = json_decode($ets->settings);
            $db = $setting->db->database;
            $dbPath = database_path('db/'.$db.'.sqlite');
            if(!\File::exists($dbPath)){
                exec('touch database/db/' . $db . '.sqlite');
                $this->etablissementRepository->update($ets->id, ['status'=> 1]);
                $this->info('db crreate : '.$db);
            }
        }
        
        $path = $this->arguments('path');
        $companies = $this->etablissementRepository->getAll(1); # établissements actifs

        foreach($companies as $company) {
            # Switch to current company database
            $settings = json_decode($company->settings);

            $database = $settings->db->database;

            // config()->set('database.connections.migration', [
            //     'driver' => 'mysql',
            //     'host' => env('DB_HOST', '127.0.0.1'),
            //     'port' => env('DB_PORT', '3306'),
            //     'database' => $settings->db->database,
            //     'username' => $settings->db->username,
            //     'password' => $settings->db->password,
            //     'unix_socket' => env('DB_SOCKET', ''),
            //     'charset' => 'utf8mb4',
            //     'collation' => 'utf8mb4_unicode_ci',
            //     'prefix' => '',
            //     'strict' => true,
            //     'engine' => null,
            // ]);
            config()->set('database.connections.migration', [
                'driver' => 'sqlite',
                'url' => env('DATABASE_URL'),
                // 'database' => 'storage/db/'.$settings->db->database.'.sqlite',
                'database' => env('DB_DATABASE', database_path('db/'.$settings->db->database.'.sqlite')),
                'prefix' => '',
                // 'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
                'foreign_key_constraints' => true,
            ]);

            DB::purge('migration');

            $connection = DB::connection('migration');

            Config::set('database.default', $connection->getName());

            $this->info($connection->getName());
            // dd($path);
            // dd($path['path']);
            
            Artisan::call('migrate', [ '--path' => '/database/migrations/'.$path['path'],'--force' => true]);

            $data = Artisan::output();

            $this->info("Database: ${database}");

            $this->info($data);

            $this->info("Nouveau environnement crée !");
        }


        return 0;
    }
}
