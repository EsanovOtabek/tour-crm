<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\Currency;
use Nnjeim\World\Models\Language;

class Guide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'guide_category_id',
        'tour_city_id',
        'price',
        'currency_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GuideCategory::class, 'guide_category_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function tour_city(): BelongsTo
    {
        return $this->belongsTo(TourCity::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'guide_language');
    }

    public function bookingGuides()
    {
        return $this->hasMany(BookingGuide::class);
    }

}
