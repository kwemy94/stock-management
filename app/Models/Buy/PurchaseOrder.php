<?php

namespace App\Models\Buy;

use App\Models\Supplier;
use App\Models\Sale\SalePayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchaseOrderLines(){
        return $this->hasMany(PurchaseOrderLine::class, 'purchase_order_id');
    }

    // public function goodsReceipts(){
    //     return $this->hasMany(GoodsReceipt::class, 'purchase_order_id');
    // }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    // public function payments()
    // {
    //     return $this->hasMany(SalePayment::class, 'invoice_id');
    // }
}
