<?php

namespace App\Repositories\Sale;

use App\Models\Sale\SaleInvoice;
use App\Repositories\ResourceRepository;

class SaleInvoiceRepository extends ResourceRepository
{

    public function __construct(SaleInvoice $saleInvoice)
    {
        $this->model = $saleInvoice;
    }

    public function getConfirmInvoice()
    {
        return $this->model->with('customer', 'payments', 'invoiceLines')
            ->where('status', 'confirmed')
            ->orderBy('id', 'DESC')->get();
    }
    public function getDevisInvoice()
    {
        return $this->model->with('customer', 'payments', 'invoiceLines')
            ->where('status', 'proformat')
            ->orderBy('id', 'DESC')->get();
    }
    public function getDraftInvoice()
    {
        return $this->model->with('customer', 'payments', 'invoiceLines')
            ->where('status', 'draft')
            ->orderBy('id', 'DESC')->get();
    }
    public function getAll()
    {
        return $this->model->with('customer', 'payments', 'invoiceLines')->orderBy('id', 'DESC')->get();
    }

}
