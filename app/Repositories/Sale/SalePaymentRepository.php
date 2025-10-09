<?php

namespace App\Repositories\Sale;

use App\Models\Sale\SalePayment;
use App\Repositories\ResourceRepository;

class SalePaymentRepository extends ResourceRepository
{

    public function __construct(SalePayment $salePayment)
    {
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

    public function getEncaissement()
    {
        $week = $this->model
            ->whereBetween('date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->get();

        $month = $this->model
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get();

        $year = $this->model
            ->whereYear('date', now()->year)
            ->get();

        $day = $this->model
            ->whereDate('date', now()->toDateString())
            ->get();

            
            
            
            # Retourner les encaissement
        return [
            "totalDay" => $day->sum('montant'),
            "totalWeek" => $week->sum('montant'),
            "totalMonth" => $month->sum('montant'),
            "totalYear" => $year->sum('montant'),
            // "CADay" => $dayCA,
        ];
    }

}
