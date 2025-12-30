<?php

namespace App\Repositories\Config;


use App\Models\Config\Plan;
use App\Repositories\ResourceRepository;

class PlanRepository extends ResourceRepository {

    public function __construct(Plan $plan) {
        $this->model = $plan;
    }

    public function getAll($n = null) 
    {
        if ($n !== null) {
            return $this->model->orderBy('id', 'DESC')->paginate($n);
        }
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
