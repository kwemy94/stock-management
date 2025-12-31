<?php

namespace App\Jobs;

use Throwable;
use App\Models\Etablissement;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\EtablissementActivationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SetupTenantEnvironmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $etablissementId,
        public string $database,
        public string $token
    ) {
    }

    public function handle(): void
    {
        $etablissement = Etablissement::findOrFail($this->etablissementId);

        try {
            // 1️⃣ Création DB
            Artisan::call('db:create', ['name' => $this->database]);

            // 2️⃣ Switch DB
            toggleDatabaseById($etablissement->id);

            // 3️⃣ Migration
            Artisan::call('migrate', ['--path' => 'database/migrations/backend_db', '--force' => true]);

            // 4️⃣ Seed
            Artisan::call('db:seed', ['--class' => 'SettingSeeder', '--force' => true]);

            // 5️⃣ Update status
            toggleDatabase(false);
            $etablissement->update(['status' => 1]);

            // 6️⃣ Mail activation
            Mail::to($etablissement->email)
                ->queue(new EtablissementActivationMail(
                    $this->token,
                    $etablissement
                ));

        } catch (Throwable $e) {
            errorManager("Tenant setup failed", $e, $e->getMessage());
            throw $e;
        }
    }
}
