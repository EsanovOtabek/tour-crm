<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'comment',
        'problem',
        'solve',
        'booking_id',
        'group_member_id',
    ];

    protected $casts = [
        'day' => 'date',
    ];

    /**
     * Get the booking that owns the daily record.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the group member that owns the daily record.
     */
    public function groupMember(): BelongsTo
    {
        return $this->belongsTo(GroupMember::class);
    }
}
