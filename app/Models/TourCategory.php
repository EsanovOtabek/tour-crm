<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function tours(){
        return $this->hasMany(Tour::class);
    }
}
