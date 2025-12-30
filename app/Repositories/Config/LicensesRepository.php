<?php

namespace App\Repositories\Config;

use App\Models\Config\Licenses;
use App\Repositories\ResourceRepository;

class LicensesRepository extends ResourceRepository {

    public function __construct(Licenses $licenses) {
        $this->model = $licenses;
    }

    public function getAll($n = null) 
    {
        if ($n !== null) {
            return $this->model->with('plan', 'company')
            ->orderBy('id', 'DESC')->paginate($n);
        }
        return $this->model->with('plan', 'company')
        ->orderBy('id', 'DESC')->get();
    }

}
