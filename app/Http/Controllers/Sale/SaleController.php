<?php

namespace App\Http\Controllers\Sale;

use App\Models\Sale\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Sale\SaleRepository;

class SaleController extends Controller
{

    private $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }
    
    public function index()
    {
        toggleDBsqlite();
        $sales = $this->saleRepository->getAll();
        // dd($sales);
        return view('admin.sale.index', compact('sales'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Sale $sale)
    {
        //
    }

    
    public function edit(Sale $sale)
    {
        //
    }

    
    public function update(Request $request, Sale $sale)
    {
        //
    }

    
    public function destroy(Sale $sale)
    {
        //
    }
}
