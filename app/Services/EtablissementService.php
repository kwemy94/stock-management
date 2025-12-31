<?php

namespace App\Services;

use App\Jobs\SetupTenantEnvironmentJob;
use App\Models\Etablissement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EtablissementService
{
    public function createEtablissement(Request $request): Etablissement
    {
        return DB::transaction(function () use ($request) {

            // 1️⃣ Upload logo
            $logo = null;
            if ($request->hasFile('logo')) {
                $logo = Str::uuid() . '.' . $request->logo->extension();
                Storage::disk('public')->putFileAs('etablissement/logo', $request->logo, $logo);
            }

            // 2️⃣ Génération DB tenant
            $database = '2s_' . Str::slug($request->name, '_') . '_' . time();

            // 3️⃣ Settings JSON
            $settings = [
                'db' => [
                    'database' => $database,
                    'username' => env('TENANT_DB_USER', 'root'),
                    'password' => env('TENANT_DB_PASSWORD', ''),
                ],
                'momo' => [],
            ];

            // 4️⃣ Création établissement
            $etablissement = Etablissement::create([
                ...$request->except('logo'),
                'logo' => $logo,
                'status' => 2, // DB non créée
                'settings' => json_encode($settings),
            ]);

            // 5️⃣ Création admin
            $token = Str::random(64);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(32)),
                'activation_token' => $token,
                'etablissement_id' => $etablissement->id,
            ]);

            // 6️⃣ Job asynchrone
            SetupTenantEnvironmentJob::dispatch(
                $etablissement->id,
                $database,
                $token
            );

            return $etablissement;
        });
    }
}
