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
        toggleDatabase();
        $products = $this->productRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        toggleDatabase();
        $categories = $this->categoryRepository->getAll();
        $units = $this->unitRepository->getAll();
        return view('admin.product.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        toggleDatabase();

        // Validation
        $validation = Validator::make(
            $request->all(),
            [
                'product_name' => 'required|string|max:255',
                'stock_quantity' => 'required|integer|min:0',
                'unit_price' => 'required|numeric|min:0',
                'product_image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024', // 1MB max
            ],
            [
                'product_name.required' => 'Nom du produit requis.',
                'stock_quantity.required' => 'Stock initial requis.',
                'stock_quantity.integer' => 'Le stock doit être un nombre entier.',
                'unit_price.required' => 'Prix unitaire requis.',
                'unit_price.numeric' => 'Le prix doit être un nombre.',
                'product_image.image' => 'Le fichier doit être une image valide.',
                'product_image.mimes' => 'L’image doit être au format jpeg, png ou jpg.',
                'product_image.max' => 'L’image ne doit pas dépasser 1MB.',
            ]
        );

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $inputs = $request->except(['product_image']);

        // Générer le code-barres
        [$codeProduit, $barcode] = generateProductBarcode();
        $inputs['code'] = $codeProduit;
        $inputs['barcode'] = "xx";
        // dd($inputs, $request->all());

        // Gestion de l'image
        if ($request->hasFile('product_image')) {
            $productImage = $request->file('product_image');
            $filename = Str::uuid() . '.' . $productImage->getClientOriginalExtension();
            $productImage->storeAs('public/images/products', $filename);
            $inputs['product_image'] = $filename;
        }

        // Enregistrement en base
        try {
            $product = $this->productRepository->store($inputs);

            return redirect()->route('product.index')->with('success', __('product.store.success'));
        } catch (\Throwable $th) {
            // Log l'erreur pour debug
            \Log::error('Erreur lors de l\'enregistrement du produit : ' . $th->getMessage());

            return redirect()->back()->with('error', __('product.store.error'));
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        toggleDatabase();
        $product = $this->productRepository->getById($id);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // dd($product);
        toggleDatabase();
        $product = $this->productRepository->getById($id);
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
        toggleDatabase();
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
        toggleDatabase();

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
        toggleDatabase();
        $products = $this->productRepository->getAll();

        // Générer l'image du code-barres à la volée pour chaque produit
        foreach ($products as $product) {
            [$code, $barcode] = generateProductBarcode($product->code);
            $product->barcode_base64 = base64_encode($barcode);
        //     $product->qrcode_base64 = base64_encode(
        // QrCode::format('png')
        //       ->size(150)          // taille en pixels
        //       ->generate($product->code));  // ici on encode le code unique du produit
        }


        $data = [
            'title' => 'liste des produits',
            'date' => date('m/d/Y H:m:s'),
            'products' => $products,
        ];
        // $title = 'liste des produits';
        //     $date = date('m/d/Y H:m:s');
        //     // $products' => $products,
        // return view('admin.product.print-barcode-to-pdf', compact('title', 'date', 'products'));
        $pdf = PDF::loadView('admin.product.print-barcode-to-pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setWarnings(false);

        return $pdf->download('client.pdf');
        return $pdf->stream('produits.pdf');
    }
}
