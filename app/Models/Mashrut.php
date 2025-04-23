<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mashrut extends Model
{
    protected $fillable = [
        'tour_city_id',
        'booking_id',
        'date_time',
        'program',
        'order_no',
    ];
    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function tourCity()
    {
        return $this->belongsTo(TourCity::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
