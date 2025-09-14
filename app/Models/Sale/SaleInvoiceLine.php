<?php

namespace App\Models\Sale;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleInvoiceLine extends Model
{
    use HasFactory;

    protected $table = 'sale_invoice_lines';

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(SaleInvoice::class, 'invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
