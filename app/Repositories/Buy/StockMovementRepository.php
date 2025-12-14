<?php

namespace App\Repositories\Buy;


use App\Models\Buy\StockMovement;
use App\Repositories\ResourceRepository;

class StockMovementRepository extends ResourceRepository {

    public function __construct(StockMovement $stockMovement) {
        $this->model = $stockMovement;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
