<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Language;

class Guide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'guide_category_id',
        'city_id',
        'price',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GuideCategory::class, 'guide_category_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'shahar_id');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'guide_language');
    }
}
