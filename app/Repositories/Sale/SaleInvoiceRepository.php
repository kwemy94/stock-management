<?php

namespace App\Repositories\Sale;

use App\Models\Sale\SaleInvoice;
use Illuminate\Support\Facades\DB;
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
            ->orWhere('status', 'Payé')
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

    public function getById($id)
    {
        return $this->model->where('id', $id)->with('customer', 'payments', 'invoiceLines', 'invoiceLines.product', 'invoiceLines.product.unitMeasure')->first();
    }

    public function chiffreAffaire()
    {
        # bénéfice et chiffre d'affaire
        $caDay = $this->model
            ->whereDate('date', now()->toDateString())
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            ->sum(
                fn($line) =>
                ($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe
            );
        // dd($caDay);

        $caWeek = $this->model
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            ->sum(
                fn($line) => 
                // dd($line)
                ($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe
            );
        $caMonth = $this->model
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            ->sum(
                fn($line) => 
                // dd($line)
                ($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe
            );

        $caQuarter = $this->model
            ->whereBetween('date', [now()->startOfQuarter(), now()->endOfQuarter()])
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            ->sum(
                fn($line) =>
                ($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe
            );

        $caYear = $this->model
            ->whereYear('date', now()->year)
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            ->sum(
                fn($line) =>
                ($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe
            );


        $beneficeDay = $this->model
            ->whereDate('date', now()->toDateString())
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            // ;
            // dd($beneficeDay);
            ->sum(
                fn($line) =>
                (($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe)
                - ($line->quantity * $line->buy_price)
            );

        $beneficeWeek = $this->model
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            ->sum(
                fn($line) =>
                (($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe)
                - ($line->quantity * $line->buy_price)
            );
        $beneficeMonth = $this->model
            ->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            ->sum(
                fn($line) =>
                (($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe)
                - ($line->quantity * $line->buy_price)
            );
        $beneficeQuarter = $this->model
            ->whereBetween('date', [now()->startOfQuarter(), now()->endOfQuarter()])
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            // ;
            // dd($beneficeDay);
            ->sum(
                fn($line) =>
                (($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe)
                - ($line->quantity * $line->buy_price)
            );
        $beneficeYear = $this->model
            ->whereYear('date', now()->year)
            ->whereIn('status', ['Payé', 'confirmed'])
            ->with('InvoiceLines')
            ->get()
            ->flatMap->InvoiceLines
            // ;
            // dd($beneficeDay);
            ->sum(
                fn($line) =>
                (($line->quantity * $line->unit_price) * (1 - $line->remise / 100) + $line->taxe)
                - ($line->quantity * $line->buy_price)
            );

        return [
            'ca_day' => $caDay,
            'ca_week' => $caWeek,
            'ca_month' => $caMonth,
            'ca_trimestre' => $caQuarter,
            'ca_year' => $caYear,
            'benefice_day' => $beneficeDay,
            'benefice_week' => $beneficeWeek,
            'benefice_month' => $beneficeMonth,
            'benefice_trimestre' => $beneficeQuarter,
            'benefice_year' => $beneficeYear,
        ];
    }

}
