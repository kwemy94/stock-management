<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use App\Repositories\ResourceRepository;

class SettingRepository extends ResourceRepository {

    public function __construct(Setting $setting) {
        $this->model = $setting;
    }

    public function getAll() 
    {
        return $this->model->get();
    }

    public function getStructure() {
        return $this->model->first();
    }

}
