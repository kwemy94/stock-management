<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\ResourceRepository;

class OrderRepository extends ResourceRepository {

    public function __construct(Order $order) {
        $this->model = $order;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
