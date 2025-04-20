<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'balans',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(PartnerType::class, 'type_id');
    }

    public function partnerObjects()
    {
        return $this->hasMany(PartnerObject::class);
    }
}
