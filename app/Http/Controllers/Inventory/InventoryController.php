<?php

namespace App\Http\Controllers\Inventory;

use PDF;
use Illuminate\Http\Request;
use App\Models\Inventory\Inventory;
use App\Http\Controllers\Controller;
use App\Repositories\Inventory\InventoryRepository;
use App\Repositories\Setting\SettingRepository;

class InventoryController extends Controller
{

    private $inventoryRepository;
    private  $settingRepository;


    public function __construct(InventoryRepository $inventoryRepository, SettingRepository $settingRepository){
        $this->inventoryRepository = $inventoryRepository;
        $this->settingRepository = $settingRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inventory.index');
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
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    public function history(){
        toggleDBsqlite();
       try {
        $inventories = $this->inventoryRepository->getHistoryByDate();
        // dd($histoInvent');
       } catch (\Throwable $th) {
            errorManager("Echec historique inventaire", $th, $th->getMessage());
            return redirect()->back()->with('error', "Une erreur survenue");
       }

        return view('admin.achat.inventory.history-inventory', compact('inventories'));
    }

    public function printInventory($inventory_date) {
        toggleDBsqlite();

        try {
            $inventories = $this->inventoryRepository->getHistoryByDate($inventory_date);
            $setting = $this->settingRepository->getFirstSetting();

            $data = [
                'setting' => $setting,
                'title' => 'Historique inventaire du '.$inventory_date,
                'inventories' => $inventories,
            ];
            $customPaper = array(0, 0, 792.00, 1224.00);
            $pdf = PDF::loadView('admin.achat.inventory.print-inventory', $data)
                ->setPaper($customPaper, 'portrait')->setWarnings(false);
    
            
        } catch (\Throwable $th) {
            errorManager("Echec d'impression inventaire", $th, $th->getMessage());
            return redirect()->back()->with('error', "Une erreur survenue");
        }
        
        return $pdf->stream();
    }
}
