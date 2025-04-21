<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{

    protected $fillable = [
        'name',
        'code',
        'unique-code',
        'status',
        'day_quantity',
        'tour_category_id',
    ];

    public function category(){
        return $this->belongsTo(TourCategory::class);
    }

    public function price_list()
    {
        return $this->hasMany(PriceList::class);
    }
}
