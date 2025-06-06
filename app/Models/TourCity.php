<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\Country;

class TourCity extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'code',
        'country_id',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function guides()
    {
        return $this->hasMany(Guide::class);
    }
}
