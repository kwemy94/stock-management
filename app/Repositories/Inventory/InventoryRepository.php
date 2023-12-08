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

}
