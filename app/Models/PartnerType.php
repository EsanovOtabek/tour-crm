<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function partners()
    {
        return $this->hasMany(Partner::class, 'type_id');
    }

}
