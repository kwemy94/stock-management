<?php

namespace App\Http\Controllers\Treasury;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnalyseController extends Controller
{
    private $analyseRepository;
    // public function __construct(AnalyseRepository $analyseRepository){
    //     $this->analyseRepository = $analyseRepository;
    // }

    public function index(){
        return view('admin.treasury.index');
    }
}
