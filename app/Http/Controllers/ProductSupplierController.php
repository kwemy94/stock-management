<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ProductSupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\Inventory\InventoryRepository;
use App\Repositories\ProductSupplier\AchatRepository;

class ProductSupplierController extends Controller
{
    protected $achatRepository;
    protected $productRepository;
    protected $supplierRepository;
    private $inventoryRepository;

    public function __construct(
        AchatRepository $achatRepository,
        ProductRepository $productRepository,
        SupplierRepository $supplierRepository,
        InventoryRepository $inventoryRepository
    ) {
        $this->achatRepository = $achatRepository;
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function index()
    {

        toggleDBsqlite();
        $achats = $this->achatRepository->getAll();

        return view('admin.achat.index', compact('achats'));
    }


    public function create()
    {
        toggleDBsqlite();
        $products = $this->productRepository->getAll();
        $suppliers = $this->supplierRepository->getAll();

        return view('admin.achat.create', compact('products', 'suppliers'));
    }


    public function store(Request $request)
    {
        toggleDBsqlite();
        $validation = Validator::make(
            $request->all(),
            [
                'product_id' => 'required',
                'supplier_id' => 'required|integer',
                'quantity' => 'required',
            ],
        );

        if ($validation->fails()) {

            dd($validation->errors());

            return redirect()->back()->withErrors($validation->errors())->withInput();
        }

        $inputs = $request->post();
        try {

            DB::transaction(function () use ($inputs) {
                $this->achatRepository->store($inputs);

                $product = $this->productRepository->getById($inputs['product_id']);

                $product->stock_quantity += $inputs['quantity'];

                $this->productRepository->update($product->id, ['stock_quantity' => $product->stock_quantity]);
            });

            return redirect(route('achat.index'))->with('success', "Achat enregistré");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Oups!! Echec d'enregistrement");
        }
    }


    public function show(ProductSupplier $productSupplier)
    {
        //
    }


    public function edit($id)
    {
        toggleDBsqlite();
        $products = $this->productRepository->getAll();
        $suppliers = $this->supplierRepository->getAll();
        try {
            $achat = $this->achatRepository->getById($id);
            return view('admin.achat.edit', compact('achat', 'products', 'suppliers'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', "Oups!! Une erreur s'est produite");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        toggleDBsqlite();
        try {
            $achat = $this->achatRepository->getById($id);
            // dd($achat);
            $this->achatRepository->update($achat->id, ['quantity' => $request->quantity]);

            return redirect(route('achat.index'))->with('success', 'Mise à jour effectué');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Oups!! Echec de mise à jour');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        toggleDBsqlite();
        try {
            $achat = $this->achatRepository->getById($id);

            $achat->delete();

            return redirect(route('achat.index'))->with('success', "Suppression reussie");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Oups!! Echec de suppression");
        }
    }


    public function inventory()
    {
        $inventories = $this->achatRepository->getInventory();
        // dd($inventories);
        return view('admin.achat.inventory.index', compact('inventories'));
    }

    public function storeInventory(Request $request)
    {
        // dd($request->all());

        $quantities = $request->quantity;
        $suppliers = $request->supplier_id;
        $products = $request->product_id;
        $initialStock = $request->initial_stock;
        $availableStock = $request->available_stock;
        $comments = $request->comment;

        toggleDBsqlite();
        #update des produit de achat avec les nouvelles valeurs renseignées
        try {
            DB::transaction(function () use ($quantities, $initialStock, $availableStock, $comments, $products, $suppliers) {
                foreach ($quantities as $key => $qty) {
                    #delete products where id
                    $this->achatRepository->deleteProductLine($products[$key]);

                    $newBuy = [
                        'product_id' => $products[$key],
                        'supplier_id' => $suppliers[$key],
                        'quantity' => $qty
                    ];
                    $this->achatRepository->store($newBuy);

                    #mise à jour du stock des articles
                    $this->productRepository->update($products[$key], ['stock_quantity' => $qty]);
                    #store invent;
                    $invent = [
                        'product_id' => $products[$key],
                        'comment' => $comments[$key],
                        'gap' => $qty - $availableStock[$key],
                        'initial_stock' => $initialStock[$key],
                        'available_stock' => $availableStock[$key],
                        'inventory_date' => Carbon::now()->toDateString(),
                    ];
                    $this->inventoryRepository->store($invent);

                }
            });
        } catch (\Throwable $th) {
            // dd($th);
            errorManager("Echec inventaire", $th, $th->getMessage());
            return redirect()->back()->with('error', 'Echec de création d\'inventaire');
        }
        return redirect()->route('achat.index')->with('success', "Inventaire reussi");


    }
}
