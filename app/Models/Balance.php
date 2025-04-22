<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nnjeim\World\Models\Currency;

class Balance extends Model
{
    protected $fillable = ['name', 'currency_id', 'amount'];


    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

}
