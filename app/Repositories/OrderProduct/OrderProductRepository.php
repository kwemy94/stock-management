<?php

namespace App\Repositories\OrderProduct;

use App\Models\OrderProduct;
use App\Repositories\ResourceRepository;

class OrderProductRepository extends ResourceRepository {

    public function __construct(OrderProduct $orderProduct) {
        $this->model = $orderProduct;
    }

    public function getAll() 
    {
        return $this->model->OrderBy('id', 'DESC')->get();
    }

}
