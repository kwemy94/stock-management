<?php

namespace App\Repositories\Buy;

use App\Models\Buy\PurchaseOrderLine;
use App\Repositories\ResourceRepository;

class PurchaseOrderLineRepository extends ResourceRepository {

    public function __construct(PurchaseOrderLine $purchaseOrderLine) {
        $this->model = $purchaseOrderLine;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

    public function destroyCommandLine($command_id) {
        $this->model->where('purchase_order_id',$command_id)->delete();
    }
}
