<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingGuide extends Model
{
    protected $fillable = [
        'booking_id',
        'guide_id',
        'tour_city_id',
        'user_id',
        'summa',
        'comment',
        'sana',
    ];

    protected $casts = [
        'sana' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function tourCity()
    {
        return $this->belongsTo(TourCity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
