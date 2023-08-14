<?php

namespace App\Repositories\Supplier;

use App\Models\Supplier;
use App\Repositories\ResourceRepository;

class SupplierRepository extends ResourceRepository {

    public function __construct(Supplier $supplier) {
        $this->model = $supplier;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
