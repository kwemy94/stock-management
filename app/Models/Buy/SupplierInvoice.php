<?php

namespace App\Models\Buy;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierInvoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
