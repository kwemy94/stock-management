<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalePayment extends Model
{
    use HasFactory;

    protected $table = 'sale_payments';

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(SaleInvoice::class, 'invoice_id');
    }
}
