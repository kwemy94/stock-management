<?php

namespace App\Repositories\Buy;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Buy\StockMovement;
use App\Repositories\ResourceRepository;

class StockMovementRepository extends ResourceRepository
{

    public function __construct(StockMovement $stockMovement)
    {
        $this->model = $stockMovement;
    }

    public function getAll(Request $request)
    {
        // return $this->model->with('goodsReceipt', 'product')->orderBy('id', 'DESC')->get();

        $date = $request->get('date')
            ? Carbon::parse($request->date)
            : Carbon::today();

        // Données du jour
        $movements = $this->model->with('product')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'movements' => $movements,
            'currentDate' => $date,
            'prevDate' => $date->copy()->subDay(),
            'nextDate' => $date->copy()->addDay(),
        ];
    }

}
