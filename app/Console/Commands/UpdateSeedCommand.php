<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\Etablissement\EtablissementRepository;

class UpdateSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exécution des seeds sur les bd back-end';

    private $etablissementRepository;
    public function __construct(EtablissementRepository $etablissementRepository)
    {
        parent::__construct();
        $this->etablissementRepository = $etablissementRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $etablissements = $this->etablissementRepository->getAll();
        try {
            foreach ($etablissements as $ets) {
                $settings = json_decode($ets->settings);
                $dbName = $settings->db->database;

                toggleDatabaseById($ets->id);

                # cette ligne recupère la config de la bd dans le fichier database.connections
                $name = DB::connection()->getName();

                Artisan::call('db:seed', ['--database' => $name, '--force' => true,]);
                $this->info(Artisan::output());

                $this->info("seed Database: $dbName complet !");



            }
        } catch (\Throwable $th) {
            // dd($th);
            $this->info("Seed error");
        }
    }
}
