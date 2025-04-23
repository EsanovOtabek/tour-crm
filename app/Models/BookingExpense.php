<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingExpense extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'expense_id',
        'title',
        'amount',
        'description',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}
