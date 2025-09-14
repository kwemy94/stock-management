<?php

namespace App\Models;

use App\Models\Inventory\Inventory;
use App\Models\Sale\SaleInvoiceLine;
use App\Models\Sale\SalePricing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function supplier() {
        return  $this->belongsToMany(Supplier::class);
    }

    public function inventories() {
        return  $this->hasMany(Inventory::class);
    }
    public function order() {
        return  $this->belongsToMany(Order::class);
    }
    public function order_product() {
        return  $this->hasMany(OrderProduct::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function unitMeasure() {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function salePricing() {
        return  $this->hasMany(SalePricing::class);
    }
    public function saleInvoiceLines() {
        return  $this->hasMany(SaleInvoiceLine::class);
    }
}
