<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\ResourceRepository;

class CustomerRepository extends ResourceRepository {

    public function __construct(Customer $customer) {
        $this->model = $customer;
    }

    public function getAll() 
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

}
