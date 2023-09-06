<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function supplier() {
        return  $this->belongsToMany(Supplier::class);
    }

    // public function customer() {
    //     return  $this->belongsToMany(Customer::class);
    // }
    public function order() {
        return  $this->belongsToMany(Order::class);
    }
    public function order_product() {
        return  $this->hasMany(OrderProduct::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
