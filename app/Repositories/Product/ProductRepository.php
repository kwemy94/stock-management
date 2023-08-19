<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\ResourceRepository;

class ProductRepository extends ResourceRepository {

    public function __construct(Product $product) {
        $this->model = $product;
    }

    public function getAll() 
    {
        return $this->model->with('category')->orderBy('id', 'DESC')->get();
    }

}
