<?php

namespace App\Repositories\Inventory;

use App\Models\Inventory\Inventory;
use App\Repositories\ResourceRepository;

class InventoryRepository extends ResourceRepository {

    public function __construct(Inventory $inventory) {
        $this->model = $inventory;
    }

    public function getAll() 
    {
        return $this->model->InventoryBy('id', 'DESC')->get();
    }

    public function getHistoryByDate($date = null){

        if (isset($date)) {
            $result = $this->model->with('product')->where('inventory_date', $date)->get();
        } else {
            $result = $this->model->groupBy('inventory_date')
            ->with('product')
            ->select('inventory_date')
            ->get();
        }
        
        

        return $result;
    }

}
