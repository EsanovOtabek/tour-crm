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
    public function guides()
    {
        return $this->hasMany(BookingGuide::class);
    }
    public function mashruts()
    {
        return $this->hasMany(Mashrut::class);
    }
    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function getRecommendedPrice() // nomini o'zgartirdik
    {
        // Group member count
        $member_count = $this->groupMembers()->count();
        // Current booking price
        $booking_price = $this->price;
        // Get associated tour
        $tour = $this->tour;

        if (!$tour) {
            return ['recommendation' => false];
        }

        // Get price lists sorted by quantity
        $price_list = $tour->price_lists()->orderBy('quantity')->get();

        // Initialize recommended price
        $recommended_price = $booking_price;
        $recommended_member = 1;

        // Find the appropriate recommended price
        foreach ($price_list as $pl) {
            if ($member_count >= $pl->quantity) {
                $recommended_price = $pl->price;
                $recommended_member = $pl->quantity;
            }
        }

        // Check if recommended price is different from the original booking price
        if ($recommended_price == $booking_price) {
            return ['recommendation' => false];
        } else {
            return [
                'recommendation' => true,
                'member' => $recommended_member,
                'price' => $recommended_price,
            ];
        }
    }



}
