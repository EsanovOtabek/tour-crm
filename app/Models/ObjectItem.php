<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\Currency;

class ObjectItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'sale_price', 'currency_id', 'contact', 'partner_object_id'];

    public function partnerObject()
    {
        return $this->belongsTo(PartnerObject::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

}
