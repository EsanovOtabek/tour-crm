<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $fillable = ['tour_id', 'quantity', 'price'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

}
