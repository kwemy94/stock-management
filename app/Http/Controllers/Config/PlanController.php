<?php

namespace App\Http\Controllers\Config;

use App\Models\Config\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Config\PlanRepository;

class PlanController extends Controller
{
    private $planRepository;

    public function __construct(
        PlanRepository $planRepository
    ) {
        $this->planRepository = $planRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = $this->planRepository->getAll();
        return view('admin.etablissement.plans.index', compact('plans'));
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
                'name' => 'required|string|max:100|unique:plans,name',
                'price' => 'required|numeric|min:0',
                'duration_days' => 'required|integer|min:1',

                'limits.users' => 'nullable|integer|min:1',
                'limits.products' => 'nullable|integer|min:1',

                'features' => 'nullable|array',
            ]);
            // dd($request->all());

            // 🔹 Normalisation des features (checkbox non cochée = false)
            $features = collect([
                'reports',
                'multi_store',
                'api_access',
            ])->mapWithKeys(function ($feature) use ($request) {
                return [$feature => $request->has("features.$feature")];
            })->toArray();

            // 🔹 Nettoyage des limites (null = illimité)
            $limits = array_filter($validated['limits'] ?? [], function ($value) {
                return !is_null($value);
            });

            $inputs['name'] = $validated['name'];
            $inputs['price'] = $validated['price'];
            $inputs['duration_days'] = $validated['duration_days'];
            $inputs['features'] = $features;
            $inputs['limits'] = $limits;

            $this->planRepository->store($inputs);

            return redirect()
                ->route('plans.index')
                ->with('success', 'Plan créé avec succès');
        } catch (\Throwable $th) {
            dd($th);
            Log::info("Erreur lors de la création du plan : " . $th->getMessage());
            Log::info("Erreur LINE : " . $th->getLine());
            Log::info("Erreur FILE : " . $th->getFile());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Erreur lors de la création du plan : " . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
