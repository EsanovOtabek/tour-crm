<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourTemplateMashrut extends Model
{
    protected $fillable = [
        'tour_template_id',
        'tour_city_id',
        'day_number',
        'program',
        'order_no',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(TourTemplate::class, 'tour_template_id');
    }

    public function tourCity(): BelongsTo
    {
        return $this->belongsTo(TourCity::class);
    }
}
