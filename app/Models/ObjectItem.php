<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjectItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'sale_price', 'partner_object_id'];

    public function partnerObject()
    {
        return $this->belongsTo(PartnerObject::class);
    }

}
