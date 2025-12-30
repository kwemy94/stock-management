<?php

namespace App\Http\Controllers\buy;

use Illuminate\Http\Request;
use App\Models\Buy\StockMovement;
use App\Http\Controllers\Controller;
use App\Repositories\Buy\StockMovementRepository;

class StockMovementController extends Controller
{
    private $stockMovementRepository;

    public function __construct(StockMovementRepository $stockMovementRepository)
    {
        $this->middleware('can:view stock movements')->only(['index']);
        $this->stockMovementRepository = $stockMovementRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        toggleDatabase();
        $movts = $this->stockMovementRepository->getAll($request);
        $prevDate = $movts['prevDate'];
        $currentDate = $movts['currentDate'];
        $nextDate = $movts['nextDate'];
        $movements = $movts['movements'];

        return view('admin.achat.stock_movement.index', compact(
            'movements',
            'currentDate',
            'prevDate',
            'nextDate'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMovement $stockMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        //
    }
}
