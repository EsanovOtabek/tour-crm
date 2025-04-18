<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function partners()
    {
        return $this->hasMany(Partner::class, 'type_id');
    }

}
