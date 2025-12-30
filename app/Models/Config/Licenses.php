<?php

namespace App\Models\Config;

use App\Models\Config\Plan;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Licenses extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'starts_at',
        'expires_at',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function company()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id', 'id');
    }
}
