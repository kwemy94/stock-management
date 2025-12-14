<?php

namespace App\Models\Buy;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsReceiptLine extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function goodReceipt(){
        return $this->belongsTo(GoodsReceipt::class, 'goods_receipt_id');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
