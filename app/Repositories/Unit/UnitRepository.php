<?php

namespace App\Repositories\Unit;

use App\Models\Unit;
use App\Repositories\ResourceRepository;

class UnitRepository extends ResourceRepository {

    public function __construct(Unit $unit) {
        $this->model = $unit;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
