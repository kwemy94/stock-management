<?php

namespace App\Repositories\PaymentMode;

use App\Models\PaymentMode;
use App\Repositories\ResourceRepository;

class PaymentModeRepository extends ResourceRepository {

    public function __construct(PaymentMode $paymentMode) {
        $this->model = $paymentMode;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
