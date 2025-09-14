<?php

namespace App\Http\Controllers\buy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyInvoiceController extends Controller
{
    public function __construct(){

    }


    public function index(){
        return view('admin.achat.buy-invoice.index');
    }

    public function create(){
        return view('admin.achat.buy-invoice.create');
    }
}
