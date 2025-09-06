<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Repositories\Supplier\SupplierRepository;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        toggleDatabase();
        $suppliers = $this->supplierRepository->getAll();
        return view('admin.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->post();
        // dd($inputs);

        toggleDatabase();
        try {
            $this->supplierRepository->store($inputs);
            return redirect(route('supplier.index'))->with('success', 'Fournisseur crée !');
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th);
            return redirect()->back()->with('error', 'Oups!! Echec de création du fournisseur.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        toggleDatabase();
        $supplier = $this->supplierRepository->getById($id);
        return view('admin.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        toggleDatabase();
        if (!$this->supplierRepository->getById($id)) {
            return redirect()->back()->with('error', "Oups!! Ce fourisseur n'existe pas");
        }
        $inputs = $request->post();

        try {
            $this->supplierRepository->update($id, $inputs);
            return redirect()->route('supplier.index')->with('success', "Fournisseur mis à jour!");
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', "Oups!! Echec de mis à jour...");
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        toggleDatabase();
        $supplier = $this->supplierRepository->getById($id);
        if (!$supplier) {
            return redirect()->back()->with('error', "Oups!! Ce fourisseur n'existe pas");
        }

        try {
            $supplier->delete();
            return redirect()->route('supplier.index')->with('Success', "Fournisseur supprimé");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Oups!! Echec de suppression");
            
        }
    }
}
