<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideCategory extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function guides()
    {
        $this->hasMany(Guide::class);
    }
}
