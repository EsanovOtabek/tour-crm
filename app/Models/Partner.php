<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'balans',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(PartnerType::class, 'type_id');
    }

}
