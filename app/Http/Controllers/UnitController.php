<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Repositories\Unit\UnitRepository;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{

    private $unitRepository;

    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }
    

    public function index()
    {
        $units = $this->unitRepository->getAll();

        return view('admin.unit.index', compact('units'));
    }

    
    public function create()
    {
        return view('admin.unit.create');
    }

    
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:units',
            ],
            [
                'name.unique' => 'Unité dejà utilisée.',
            ]
        );

        if ($validation->fails()) {;
            dd($validation->errors());

            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        try {
            $this->unitRepository->store($request->post());

            return redirect(route('unite-mesure.index'))->with('success', 'Unité de mesure crée');
        } catch (\Exception $e) {
            dd($e);
            
            return redirect()->back()->with('error', 'Oups!! Echec de création');
        }
    }

    
    public function show(Unit $unit)
    {
        //
    }

    
    public function edit($id)
    {
        $unit = $this->unitRepository->getById($id);
        return view('admin.unit.create', compact('unit'));
    }

    
    public function update(Request $request, $id)
    {
        try {
            $unit = $this->unitRepository->getById($id);
            $this->unitRepository->update($unit->id, $request->post());

            return redirect(route('unite-mesure.index'))->with('success', 'Unité mise à jour !');
        } catch (\Exception $e) {
            dd($e);
            
            return redirect()->back()->with('error', 'Oups!! Echec de mise à jour');
        }
    }

    
    public function destroy($id)
    {
        try {
            $unit = $this->unitRepository->getById($id);
            $unit->delete();
            return redirect(route('unite-mesure.index'))->with('success', 'Unité supprimée !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Oups!! Echec de suppression');
        }
    }
}
