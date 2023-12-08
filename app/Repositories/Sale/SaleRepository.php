<?php

namespace App\Repositories\Sale;

use App\Models\Sale\Sale;
use App\Repositories\ResourceRepository;

class SaleRepository extends ResourceRepository {

    public function __construct(Sale $sale) {
        $this->model = $sale;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
