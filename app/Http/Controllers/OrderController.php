<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Customer\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Order\OrderRepository;
use App\Repositories\OrderProduct\OrderProductRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Setting\SettingRepository;

class OrderController extends Controller
{
    private $orderRepository;
    private $productRepository;
    private $paymentRepository;
    private $orderProductRepository;
    private $customerRepository;
    private $categoryRepository;
    private $settingRepository;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, PaymentRepository $paymentRepository, 
                    OrderProductRepository $orderProductRepository, CustomerRepository $customerRepository, CategoryRepository $categoryRepository,
                    SettingRepository $settingRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository =$productRepository;
        $this->paymentRepository =$paymentRepository;
        $this->orderProductRepository =$orderProductRepository;
        $this->customerRepository =$customerRepository;
        $this->categoryRepository =$categoryRepository;
        $this->settingRepository =$settingRepository;
    }
    
    public function index()
    {
        $orders = $this->orderRepository->getAll();

        return view('admin.pos.order.index', compact('orders'));
    }

    
    public function create()
    {
        $products = $this->productRepository->getAll();

        return view('admin.pos.order.create', compact('products'));

        return response()->json([
            'products' => $products,
        ], 200);
    }

    
    public function store(Request $request)
    {
        $user = Auth::user();
        try {
            $inputOrder['user_id'] = $user->id;
            $inputOrder['customer_id'] = $request->customer_id ?? null;

            DB::transaction(function () use($inputOrder, $user, $request) {
                $order = $this->orderRepository->store($inputOrder);

                $payment['amount'] = $request->amount;
                $payment['order_id'] = $order->id;
                $payment['user_id'] = $user->id;
                $this->paymentRepository->store($payment);

                ### Sauvegarde des produits selectionner dans le pos
                // $orderProduct;
            });

        } catch (\Exception $e) {
            dd($e);
        }
    }

    
    public function show(Order $order)
    {
        //
    }

    
    public function edit(Order $order)
    {
        //
    }

    
    public function update(Request $request, Order $order)
    {
        //
    }

    
    public function destroy(Order $order)
    {
        //
    }

    public function loadProduct() {
        $products = $this->productRepository->getAll();
        $customer = $this->customerRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $setting = $this->settingRepository->getAll();

        return response()->json([
            'products' => $products,
            'customers' => $customer,
            'categories' => $categories,
            'setting' => $setting,
        ]);
    }
}
