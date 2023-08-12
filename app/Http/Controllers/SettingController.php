<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\Setting\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingRepository;

        public function __construct(SettingRepository $settingRepository){
            $this->settingRepository = $settingRepository;
        }
        
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = $this->settingRepository->getStructure();
        return view('admin.settings.structure-setting', compact('setting'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        try {
            $this->settingRepository->update($setting->id, $request->post());
            return redirect()->back()->with('success', 'Votre application à été mise à jour!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oups!! Echec de mise à jour...');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
