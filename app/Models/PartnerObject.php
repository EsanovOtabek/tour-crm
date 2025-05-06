<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerObject extends Model
{
    use SoftDeletes;

    protected $table = 'partner_objects';

    protected $fillable = [
        'name',
        'unique_code',
        'rating',
        'partner_id',
        'location',
        'tour_city_id',
        'latitude',
        'longitude',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class); // Agar Partner modeli bo‘lsa
    }

    public function items()
    {
        return $this->hasMany(ObjectItem::class);
    }

    public function city()
    {
        return $this->belongsTo(TourCity::class, 'tour_city_id');
    }
}
