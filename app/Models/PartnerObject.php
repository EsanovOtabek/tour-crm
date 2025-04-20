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
        'rating',
        'partner_id',
        'location',
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

}
