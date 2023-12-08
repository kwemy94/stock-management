<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\Setting\SettingRepository;

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
        toggleDatabase();
        $setting = $this->settingRepository->getFirstSetting();
        return view('admin.settings.structure-setting', compact('setting'));
    }

    public static function settingInfo() {
        return ["io"];
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
    public function update(Request $request, $id)
    {
        $inputs = $request->post();

        toggleDatabase();
        
        try {
            $setting = $this->settingRepository->getById($id);

            if (!is_null($request->logo)) {
                $logoImage = $request->file('logo');
                $logoName = Str::uuid() . '.' . $logoImage->getClientOriginalExtension();
                $request->logo->storeAs('public/images/logo', $logoName);
                
                $inputs['logo'] = $logoName;
            }

            $this->settingRepository->update($setting->id, $inputs);
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
