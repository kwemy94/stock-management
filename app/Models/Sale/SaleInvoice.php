<?php

namespace App\Models\Sale;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleInvoice extends Model
{
    use HasFactory;

    protected $table = 'sale_invoices';

    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function InvoiceLines()
    {
        return $this->hasMany(SaleInvoiceLine::class, 'invoice_id');
    }

    public function payments()
    {
        return $this->hasMany(SalePayment::class, 'invoice_id');
    }
}
