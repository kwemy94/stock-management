<?php

namespace App\Repositories\Sale;

use App\Models\Sale\SalePayment;
use App\Repositories\ResourceRepository;

class SalePaymentRepository extends ResourceRepository {

    public function __construct(SalePayment $salePayment) {
        $this->model = $salePayment;
    }

    public function getAll()
    {
        return $this->model->with('saleInvoice')->orderBy('id', 'DESC')->get();
    }

    public function getByInvoiceId($invoice_id)
    {
        return $this->model->with('invoice')->where('invoice_id', $invoice_id)->first();
    }

}
