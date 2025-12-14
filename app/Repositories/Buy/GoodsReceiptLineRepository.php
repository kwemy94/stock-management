<?php

namespace App\Repositories\Buy;

use App\Models\Buy\GoodsReceiptLine;
use App\Repositories\ResourceRepository;

class GoodsReceiptLineRepository extends ResourceRepository {

    public function __construct(GoodsReceiptLine $goodsReceiptLine) {
        $this->model = $goodsReceiptLine;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
