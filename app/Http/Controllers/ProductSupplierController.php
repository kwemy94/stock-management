<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\ProductSupplier\AchatRepository;

class ProductSupplierController extends Controller
{
    protected $achatRepository;
    protected $productRepository;
    protected $supplierRepository;

    public function __construct(AchatRepository $achatRepository, ProductRepository $productRepository, SupplierRepository $supplierRepository)
    {
        $this->achatRepository = $achatRepository;
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {

        toggleDatabase();
        $achats = $this->achatRepository->getAll();

        return view('admin.achat.index', compact('achats'));
    }


    public function create()
    {
        toggleDatabase();
        $products = $this->productRepository->getAll();
        $suppliers = $this->supplierRepository->getAll();

        return view('admin.achat.create', compact('products', 'suppliers'));
    }


    public function store(Request $request)
    {
        toggleDatabase();
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
        toggleDatabase();
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
        toggleDatabase();
        try {
            $achat = $this->achatRepository->getById($id);
            // dd($achat);
            $this->achatRepository->update($achat->id, ['quantity' =>$request->quantity]);

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
        toggleDatabase();
        try {
            $achat = $this->achatRepository->getById($id);

            $achat->delete();

            return redirect(route('achat.index'))->with('success', "Suppression reussie");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Oups!! Echec de suppression");
        }
    }
}
