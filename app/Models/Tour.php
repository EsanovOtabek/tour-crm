<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    public function price_lists()
    {
        return $this->hasMany(PriceList::class);
    }
}
