<?php

namespace App\Models\Buy;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function goodsReceipt(){
        return $this->belongsTo(GoodsReceipt::class);
    }
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
