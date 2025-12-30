<?php

namespace App\Models;

use App\Models\Config\Plan;
use App\Models\Config\Licenses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etablissement extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function license()
    {
        return $this->hasOne(Licenses::class, 'etablissement_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'etablissement_id', 'id');
    }
}
