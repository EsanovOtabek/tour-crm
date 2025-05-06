<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'object_item_id',
        'quantity',
        'price',
        'cost_price',
        'start_date',
        'end_date',
        'user_id',
        'comment',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function objectItem()
    {
        return $this->belongsTo(ObjectItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
