<?php

namespace App\Repositories\Treasury;

use App\Models\Expense;
use App\Repositories\ResourceRepository;

class ExpenseRepository extends ResourceRepository {

    public function __construct(Expense $expense) {
        $this->model = $expense;
    }

    public function getAll()
    {
        return $this->model->get();
    }

}
