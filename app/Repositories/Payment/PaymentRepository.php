<?php

namespace App\Repositories\Payment;

use App\Models\Payment;
use App\Repositories\ResourceRepository;

class PaymentRepository extends ResourceRepository {

    public function __construct(Payment $payment) {
        $this->model = $payment;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
