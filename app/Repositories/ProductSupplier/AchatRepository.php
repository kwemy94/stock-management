<?php

namespace App\Repositories\ProductSupplier;

use App\Models\ProductSupplier;
use App\Repositories\ResourceRepository;

class AchatRepository extends ResourceRepository {

    public function __construct(ProductSupplier $achat) {
        $this->model = $achat;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
