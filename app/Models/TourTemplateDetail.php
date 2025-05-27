<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourTemplateDetail extends Model
{
    protected $fillable = [
        'tour_template_id',
        'object_item_id',
        'start_day',
        'end_day',
        'quantity',
        'price',
        'cost_price',
        'comment',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(TourTemplate::class, 'tour_template_id');
    }

    public function objectItem(): BelongsTo
    {
        return $this->belongsTo(ObjectItem::class);
    }
}
