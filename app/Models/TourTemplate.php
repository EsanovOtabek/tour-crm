<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourTemplate extends Model
{
    protected $fillable = [
        'tour_id',
        'name',
        'description',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TourTemplateDetail::class);
    }

    public function mashruts(): HasMany
    {
        return $this->hasMany(TourTemplateMashrut::class);
    }
}
