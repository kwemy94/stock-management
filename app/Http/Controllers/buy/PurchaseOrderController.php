<?php

namespace App\Http\Controllers\buy;

use PDF;
use Illuminate\Http\Request;
use App\Models\Buy\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Buy\PurchaseOrderRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\Buy\PurchaseOrderLineRepository;
use App\Repositories\PaymentMode\PaymentModeRepository;

class PurchaseOrderController extends Controller
{
    private $purchaseOrderRepository;
    private $purchaseOrderLineRepository;
    private $supplierRepository;
    private $productRepository;
    private $paymentModeRepository;
    private $settingRepository;

    public function __construct(
        PurchaseOrderRepository $purchaseOrderRepository,
        PurchaseOrderLineRepository $purchaseOrderLineRepository,
        SupplierRepository $supplierRepository,
        ProductRepository $productRepository,
        PaymentModeRepository $paymentModeRepository,
        SettingRepository $settingRepository
        )
        {
        $this->middleware('can:view purchase orders')->only(['index', 'show']);
        $this->middleware('can:create purchase orders')->only(['create', 'store']);
        $this->middleware('can:update purchase order')->only(['edit', 'update']);
        $this->middleware('can:delete purchase order')->only(['destroy']);
        $this->purchaseOrderRepository = $purchaseOrderRepository;
        $this->purchaseOrderLineRepository = $purchaseOrderLineRepository;
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
        $this->paymentModeRepository = $paymentModeRepository;
        $this->settingRepository = $settingRepository;
        
    }
    
    public function index()
    {

        toggleDatabase();
        $commands = $this->purchaseOrderRepository->getAll();
        return view('admin.achat.command.index', compact('commands'));
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
        // dd($request->all());

        try {
            toggleDatabase();
            $inputs = $request->except(['lines']);
            $lines = $request->lines;
            // dd($request->all());

            $invoiceInputs['supplier_id'] = $inputs['supplier_id'];
            $invoiceInputs['date_command'] = $inputs['dateFacture'];
            $invoiceInputs['amount'] = $inputs['montantFacture'];
            // $invoiceInputs['amount_tax'] = $inputs['montantEncaisse'];
            $invoiceInputs['status'] = $inputs['status'];
            $invoiceInputs['reference'] = generateInvoiceNumber('purchase_orders', 'BC', true, 'reference');
            

            DB::beginTransaction();
            $command = $this->purchaseOrderRepository->store($invoiceInputs);

            foreach ($lines as $line) {
                $line['purchase_order_id'] = $command->id;
                $line['remaining_quantity'] = $line['quantity'];
                
                $this->purchaseOrderLineRepository->store($line);
            }

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Commande crée avec succès !"
            ], 201);

        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Log::info("ERREUR : ". $th->getMessage());
            Log::info("ERREUR FILE : ". $th->getFile());
            return response()->json([
                "success" => false,
                "error" => $th->getMessage(),
                "message" => "Oups! Echec de création de la commande"
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        toggleDatabase();
        try {
            $commande = $this->purchaseOrderRepository->getById($id);
            return view('admin.achat.command.show', compact('commande'));
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        toggleDatabase();
        try {
            $command = $this->purchaseOrderRepository->getById($id);
            return view('admin.achat.command.edit', compact('command'));
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            toggleDatabase();
            $inputs = $request->except(['lines']);
            $lines = $request->lines;

            $commandInputs['supplier_id'] = $inputs['supplier_id'];
            $commandInputs['date_command'] = $inputs['dateFacture'];
            $commandInputs['amount'] = $inputs['montantFacture'];
            $commandInputs['status'] = $inputs['status'];

            DB::beginTransaction();
            $this->purchaseOrderRepository->update($id, $commandInputs);

            $this->purchaseOrderLineRepository->destroyCommandLine($id);
            foreach ($lines as $line) {
                $line['purchase_order_id'] = $id;
                $line['remaining_quantity'] = $line['quantity'];
                $this->purchaseOrderLineRepository->store($line);
            }

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => $commandInputs['status'] == 'validated' ? "Commande validée avec succès" : "Commande mise à jour avec succès !"
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info("ERREUR COMMANDE : ". $th->getMessage());
            Log::info("ERREUR FILE : ". $th->getFile());
            return response()->json([
                "success" => false,
                "error" => $th->getMessage(),
                "message" => "Oups! Echec de création de la commande"
            ], 500);
        }
    }
    public function confirmCommand($id)
    {
        try {
            toggleDatabase();
            
            $commandInputs['status'] = 'confirmed';

            DB::beginTransaction();
            $this->purchaseOrderRepository->update($id, $commandInputs);

            DB::commit();
            return redirect()->route('buy-command-order.index')->with('success', "Commande confirmée avec succès");
            

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info("ERREUR CONFIRMATION COMMANDE : ". $th->getMessage());
            Log::info("ERREUR FILE : ". $th->getFile());
            return response()->json([
                "success" => false,
                "error" => $th->getMessage(),
                "message" => "Oups! Echec de confirmation de la commande"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }


    public function dataCreateCommand()
    {
        toggleDatabase();
        $suppliers = $this->supplierRepository->getAll();
        $products = $this->productRepository->getAll();
        $paymentModes = $this->paymentModeRepository->getAll();

        return response()->json([
            'suppliers' => $suppliers,
            'products' => $products,
            'paymentModes' => $paymentModes,
        ]);
    }

    public function printCommand($id)
    {
        toggleDatabase();
        $command = $this->purchaseOrderRepository->getById($id);
        $setting = $this->settingRepository->getFirstSetting();
        $data = [
            'command' => $command,
            'setting' => $setting,
        ];
        // dd($setting);
        $pdf = PDF::loadView('admin.achat.command.print_command', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('commande_'.$command->reference.'.pdf');
        // return view('admin.achat.command.print_command', compact('command'));
    }
    public function sendCommand($id)
    {
        toggleDatabase();
        try {
            $command = $this->purchaseOrderRepository->getById($id);
            // Send email logic to be implemented here
            dd('TO BE SEND');

            return redirect()->back()->with('success', 'Commande envoyée avec succès !');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', "Echec d'envoi de la commande.");
        }
    }
}
