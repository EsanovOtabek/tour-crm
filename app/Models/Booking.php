<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use softDeletes;
    protected $fillable = [
        'user_id',
        'tour_id',
        'status',
        'start_date',
        'end_date',
        'total_amount',
        'price',
        'cost_price',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tour(){
        return $this->belongsTo(Tour::class);
    }

    public function expenses()
    {
        return $this->hasMany(BookingExpense::class);
    }
    public function mashruts()
    {
        return $this->hasMany(Mashrut::class);
    }
}
