<?php

namespace App\Http\Controllers;

use PDF;
use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Setting\SettingRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\OrderProduct\OrderProductRepository;

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
        toggleDatabase();
        $orders = $this->orderRepository->getAll();
        $setting = $this->settingRepository->getFirstSetting();

        return view('admin.pos.order.index', compact('orders','setting'));
    }

    
    public function create()
    {
        toggleDatabase();
        $products = $this->productRepository->getAll();

        return view('admin.pos.order.create', compact('products'));

        return response()->json([
            'products' => $products,
        ], 200);
    }

    
    public function store(Request $request)
    {
        // dd(date('Y-m-d'), $request->post());
        $user = Auth::user();

        toggleDatabase();
        $products = $this->productRepository->getAll();
        $customer = $this->customerRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $setting = $this->settingRepository->getAll();

        try {
            $inputOrder['user_id'] = $user->id;
            $inputOrder['customer_id'] = $request->customer ?? null;
            $inputOrder['date_order'] = date('Y-m-d');
            $inputOrder['status'] = 1;
            // dd($inputOrder);

            DB::transaction(function () use($inputOrder, $user, $request) {
                $order = $this->orderRepository->store($inputOrder);

                ## enregistrement du paiement
                $payment['amount'] = $request->totalCart;
                $payment['order_id'] = $order->id;
                $payment['user_id'] = $user->id;
                $payment['received_amount'] = $request->totalCart;
                $this->paymentRepository->store($payment);

                ### Sauvegarde des produits selectionner dans le pos
                $panier = $request->cartField;

                for ($i=0; $i < count($panier); $i++) { 
                    $inputs['product_id'] = $panier[$i]['prod_id'];
                    $inputs['order_id'] = $order->id;
                    $inputs['quantity'] = $panier[$i]['quantity'];
                    $inputs['price'] = $panier[$i]['total_price'];

                    $this->orderProductRepository->store($inputs);

                    ## update product quantity
                    $prod = $this->productRepository->getById($inputs['product_id']);
                    $this->productRepository->update($prod->id, ['stock_quantity' => $prod->stock_quantity - $inputs['quantity']]);
                }

                ### Automatisation tresorerie
                if($payment['received_amount'] > 0){
                    $resteAPayer = $payment['amount'] - $payment['received_amount'];

                    $vente['intitule'] = "Vente POS";
                    $vente['reference'] = 'VTE00'. $order->id;
                    $vente['date'] = now();
                    $vente['amount'] = $payment['received_amount'];
                    $vente['amount_du'] = $resteAPayer;
                    $vente['status'] = $resteAPayer <= 0? 1 : 0;
                    $vente['created_by'] = $user->name;

                    if(!automationRecipe($vente)){
                        throw new Exception("Echec automatisation tresorery", 1);
                        
                    }
                }
                
            });

            return response()->json([
                'success' => true,
                'products' => $products,
                'customers' => $customer,
                'categories' => $categories,
                'setting' => $setting,
            ], 201);

        } catch (Exception $e) {
            // dd($e);
            errorManager("Ordre de vente", $e, $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);
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

        toggleDatabase();
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



    public function printInvoice($id) {

        toggleDatabase();
        $order = $this->orderRepository->getById($id);
        $orderProducts = $this->orderProductRepository->getByOrderId($id);
        // dd($product, $id);
        $customer = null;
        if ($order->customer_id) {
            $customer = $this->customerRepository->getById($order->customer_id);
        }

        $setting = $this->settingRepository->getFirstSetting();

        $data = [
            'title' => 'liste des produits',
            // 'date' => date('m/d/Y H:m:s'),
            'setting' => $setting,
            'orderProducts' => $orderProducts,
            'order_id' => $id,
            'customer' => $customer,
        ];
        $customPaper = array(0, 0, 792.00, 1224.00);
        $pdf = PDF::loadView('admin.pos.order.print-invoice', $data)->setPaper($customPaper, 'portrait')->setWarnings(false);

        // return $pdf->download('command.pdf');
        return $pdf->stream();
    }
}
