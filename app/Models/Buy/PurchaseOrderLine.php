<?php

namespace App\Models\Buy;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderLine extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    }
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
