<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class createDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name?}';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = "Création d'une base de données avec artisan";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // if (is_null($this->argument('name'))) {
        //     $schemaName = $this->argument('name');
        // }
        // else {
        //     $schemaName = config("database.connections.mysql.database");
        // }
        
        try {
            $schemaName = $this->argument('name') ?: config("database.connections.mysql.database");
            $charset = config('database.connections.mysql.charset', 'utf8mb4');
            $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');
    
            config(["database.connections.mysql.database" => null]);
    
            $query = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";
            
            DB::statement($query);
            
            config(["database.connections.mysql.database" => $schemaName]);
        } catch (\Throwable $th) {
            errorManager('error create db :', $th, $th->getMessage());
            $this->info('Command DB error');
        }
        // dd('OK', $schemaName);

        $this->info("Requête terminée !");
        return 0;
    }
}
