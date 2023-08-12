<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\ResourceRepository;

class CategoryRepository extends ResourceRepository {

    public function __construct(Category $category) {
        $this->model = $category;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
