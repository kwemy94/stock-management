<?php

namespace App\Http\Controllers\buy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentMode\PaymentModeRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Supplier\SupplierRepository;

class BuyInvoiceController extends Controller
{

    private $supplierRepository;
    private $productRepository;
    private $paymentModeRepository;

    public function __construct(
        SupplierRepository $supplierRepository,
        ProductRepository $productRepository,
        PaymentModeRepository $paymentModeRepository
    ) {
        $this->middleware('can:create purchase orders')->only(['create']);
        $this->supplierRepository = $supplierRepository;
        $this->productRepository = $productRepository;
        $this->paymentModeRepository = $paymentModeRepository;
    }


    public function index()
    {
        // return view('admin.achat.buy-invoice.index');
        return view('admin.achat.buy-dashboard');
    }

    public function indexCmd()
    {
        // return view('admin.achat.buy-invoice.index');
        return view('admin.achat.command.index');
    }

    public function create()
    {
        return view('admin.achat.command.create');
    }

    public function dataCreateInvoice()
    {
        toggleDatabase();
        $customers = $this->supplierRepository->getAll();
        $products = $this->productRepository->getAll();
        $paymentModes = $this->paymentModeRepository->getAll();

        return response()->json([
            'suppliers' => $customers,
            'products' => $products,
            'paymentModes' => $paymentModes,
        ]);
    }
}
