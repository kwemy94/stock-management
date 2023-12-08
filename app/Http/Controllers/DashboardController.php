<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Customer\CustomerRepository;
use App\Repositories\Supplier\SupplierRepository;
use App\Repositories\OrderProduct\OrderProductRepository;

class DashboardController extends Controller
{
    private $productRepository;
    private $userRepository;
    private $categoryRepository;
    private $paymentRepository;
    private $supplierRepository;
    private $customerRepository;
    private $orderProductRepository;

    public function __construct(
        ProductRepository $productRepository, UserRepository $userRepository,
        CategoryRepository $categoryRepository, PaymentRepository $paymentRepository,
        SupplierRepository $supplierRepository, CustomerRepository $customerRepository,
        OrderProductRepository $orderProductRepository
    )
    {
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->supplierRepository = $supplierRepository;
        $this->paymentRepository = $paymentRepository;
        $this->orderProductRepository = $orderProductRepository;
    }
    

    public function dashboardHome() 
    {
        $user = Auth::user();
        $users = $this->userRepository->getUserByCompany($user->etablissement_id);
        toggleDatabase();

        $categories = $this->categoryRepository->getAll();
        $products = $this->productRepository->getAll();
        $customers = $this->customerRepository->getAll();
        $payments = $this->paymentRepository->getAll();
        $orders = $this->orderProductRepository->getAll();
        $suppliers = $this->supplierRepository->getAll();

        return view('admin.dashboard', compact('users', 'categories', 'customers', 'payments', 'orders', 'suppliers', 'products' ));
    }
}
