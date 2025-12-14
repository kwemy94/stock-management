<?php

namespace App\Repositories\Buy;

use App\Models\Buy\PurchaseOrder;
use App\Repositories\ResourceRepository;

class PurchaseOrderRepository extends ResourceRepository {

    public function __construct(PurchaseOrder $purchaseOrder) {
        $this->model = $purchaseOrder;
    }

    public function getById($id) 
    {
        return $this->model->where('id', $id)
        ->with('supplier', 'purchaseOrderLines.product',)
        ->first();
    }
    public function getAll() 
    {
        return $this->model->with('supplier', 'purchaseOrderLines.product',)
        ->orderBy('id', 'DESC')->get();
    }
    public function getDataToReceipt() 
    {
        return $this->model->whereIn('status', ['send','confirmed', 'partially_received'])
        ->with(['supplier', 'purchaseOrderLines.product'])
        ->orderBy('id', 'DESC')->get();
    }

}
