<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Picqer\Barcode\GeneratorHTML;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Unit\UnitRepository;

class ProductController extends Controller
{
    private $productRepository;
    private $categoryRepository;
    private $unitRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, UnitRepository $unitRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->unitRepository = $unitRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        $units = $this->unitRepository->getAll();
        return view('admin.product.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->post());
        $validation = Validator::make(
            $request->all(),
            [
                'product_name' => 'required',
                'stock_quantity' => 'required|integer',
                'unit_price' => 'required',
                // 'product_image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            ],
            [
                'product_name.required' => 'Nom du produit requis.',
                'stock_quantity.required' => 'Stock initiale requis.',
                'price.required' => 'Prix unitaire requis.',
            ]
        );

        if ($validation->fails()) {

            // return response()->json([
            //     'error' => true,
            //     'message' => $validation->errors(),
            // ]);
            dd($validation->errors());

            return redirect()->back()->withErrors($validation->errors())->withInput();
        }


        $inputs = $request->post();
        $codeProduit = generateProductBarcode();


        // dd($request->all(), $request->file('product_image'));
        try {
            // dd($this->GenerateProductBarcode());
            $inputs['code'] = $codeProduit[0];
            $inputs['barcode'] = $codeProduit[1];

            if (!is_null($request->product_image)) {
                $productImage = $request->file('product_image');
                $productName = Str::uuid() . '.' . $productImage->getClientOriginalExtension();
                $request->product_image->storeAs('public/images/products', $productName);
                
                $inputs['product_image'] = $productName;
            }


            $product = $this->productRepository->store($inputs);

            // return response()->json([
            //     'error' => false,
            //     'message' => 'Produit enregistré !',
            //     'product' => $product,
            // ]);
            return redirect()->route('product.index')->with('success', __('product.store.success'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('eroor', __('product.store.error'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // dd($product);
        $categories = $this->categoryRepository->getAll();
        $units = $this->unitRepository->getAll();
        return view('admin.product.edit', compact('product', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($product, $request->post());
        $product = $this->productRepository->getById($id);
        $inputs = $request->post();
        try {
            if ($request->hasFile('product_image')) {
                if (!is_null($product->product_image)) {
                    Storage::delete('public/images/products/' . $product->product_image);
                }

                $productImage = $request->file('product_image');
                $productName = Str::uuid() . '.' . $productImage->getClientOriginalExtension();
                $request->product_image->storeAs('public/images/products', $productName);
                
                $inputs['product_image'] = $productName;
            }
            $this->productRepository->update($id, $inputs);

            return redirect(route('product.index'))->with('success', 'Produit mise à jour !');
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
            return redirect()->back()->with('error', 'Oups!! Echec de mise à jour...');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        try {
            $product = $this->productRepository->getById($id);
        
            if (!is_null($product->product_image)) {
                Storage::delete('public/images/products/' . $product->product_image);
            }

            $product->delete();

            return redirect()->back()->with('success', 'Produit supprimé');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Echec de suppression');
        }
    }


    public function BarcodeToPDF()
    {
        $products = $this->productRepository->getAll();

        $data = [
            'title' => 'liste des produits',
            'date' => date('m/d/Y H:m:s'),
            'products' => $products,
        ];
        $pdf = PDF::loadView('admin.product.print-barcode-to-pdf', $data)->setPaper('a4', 'landscape')->setWarnings(false);

        // return $pdf->download('client.pdf');exit
        return $pdf->stream();
    }
}
