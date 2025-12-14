<?php

namespace App\Repositories\Buy;

use App\Models\Buy\GoodsReceipt;
use App\Repositories\ResourceRepository;

class GoodsReceiptRepository extends ResourceRepository {

    public function __construct(GoodsReceipt $goodsReceipt) {
        $this->model = $goodsReceipt;
    }

    public function getAll() 
    {
        return $this->model->with('purchaseOrder.supplier', 'goodReceiptLine')
        ->orderBy('id', 'DESC')->get();
    }

}
