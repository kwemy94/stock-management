<?php

namespace App\Models\Buy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function stockMovement(){
        return $this->hasMany(StockMovement::class);
    }

    public function goodReceiptLine(){
        return $this->hasMany(GoodsReceiptLine::class);
    }
}
