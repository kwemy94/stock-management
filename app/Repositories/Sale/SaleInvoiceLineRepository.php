<?php

namespace App\Repositories\Sale;

use App\Models\Sale\SaleInvoiceLine;
use App\Repositories\ResourceRepository;

class SaleInvoiceLineRepository extends ResourceRepository {

    public function __construct(SaleInvoiceLine $saleInvoiceLine) {
        $this->model = $saleInvoiceLine;
    }

    public function getAll() 
    {
        return $this->model->with('product', 'invoice')->orderBy('id', 'DESC')->get();
    }

}
