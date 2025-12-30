<?php

namespace App\Http\Controllers\Config;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PharIo\Manifest\License;
use App\Models\Config\Licenses;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Config\PlanRepository;
use App\Repositories\Config\LicensesRepository;
use App\Repositories\Etablissement\EtablissementRepository;
use Illuminate\Support\Facades\Auth;

class LicensesController extends Controller
{
    private $licensesRepository;
    private $etablissementRepository;
    private $planRepository;

    public function __construct(
        LicensesRepository $licensesRepository,
        EtablissementRepository $etablissementRepository,
        PlanRepository $planRepository
    ) {
        $this->licensesRepository = $licensesRepository;
        $this->etablissementRepository = $etablissementRepository;
        $this->planRepository = $planRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $licenses = $this->licensesRepository->getAll(10);
        $companies = $this->etablissementRepository->getAllCompany();
        $plans = $this->planRepository->getAll();

        return view('admin.etablissement.licenses.index', compact('licenses', 'companies', 'plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_id' => 'required|exists:etablissements,id|unique:licenses,etablissement_id',
                'plan_id' => 'required|exists:plans,id',
                'expires_at' => 'required|date|after:today',
                'status' => 'required|in:active,suspended',
            ]);

            // 🔑 Génération de la clé de licence
            $licenseKey = 'SS-' . strtoupper(Str::random(20));

            // 📆 Date de début = maintenant
            $startsAt = now();


            $inputs['etablissement_id'] = $validated['company_id'];
            $inputs['plan_id'] = $validated['plan_id'];
            $inputs['license_key'] = $licenseKey;
            $inputs['starts_at'] = $startsAt;
            $inputs['expires_at'] = Carbon::parse($validated['expires_at']);
            $inputs['status'] = $validated['status'];

            $this->licensesRepository->store($inputs);


            return redirect()
                ->route('licenses.index')
                ->with('success', 'Licence créée avec succès');

        } catch (\Throwable $th) {
            dd($th);
            Log::info("Erreur lors de la création de la licence : " . $th->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Echec de la création de la licence : ' . $th->getMessage());
        }
    }


    public function activate(Request $request)
    {
        try {
            $user = auth()->user();
            // dd($user->company);
            $request->validate([
                'license_key' => 'required|exists:licenses,license_key',
            ]);

            $license = Licenses::where('license_key', $request->license_key)->first();
            if ($license->etablissement_id == $user->etablissement_id) {
                    // Associer la licence à l'entreprise de l'utilisateur
                    $license->update([
                        // 'company_id' => auth()->user()->company_id,
                        'status' => 'active',
                    ]);
            } else {
                return redirect()->back()
                    ->with('error', 'Oups! Echec de l\'activation de la licence. Veuillez réessayer.');
            }


            return redirect()->route('dashboard')
                ->with('success', 'Licence activée avec succès');
        } catch (\Throwable $th) {
            // dd($th);
            //throw $th;
            return redirect()->back()
                ->with('error', 'Oups! Echec de l\'activation de la licence. Veuillez réessayer.');
        }

    }



    /**
     * Display the specified resource.
     */
    public function show(Licenses $licenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Licenses $licenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Licenses $licenses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Licenses $licenses)
    {
        //
    }
}
