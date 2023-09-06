<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function conversations_1()
    // {
    //     return $this->belongsToMany(User::class, env('DB_CONNECTION_1') . '.conversation_user', 'user_id', 'conversation_id');
    // }

    // public function conversations_2()
    // {
    //     return DB::connection('db1_connection_name')->table('conversation_user')->where('user_id', $this->id)->get();
    // }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
