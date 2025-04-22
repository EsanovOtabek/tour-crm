<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMember extends Model
{
    protected $fillable = [
        'booking_id',
        'agent_id', // Added
        'surname',
        'name',
        'passport_number',
        'email',
        'phone',
        'telegram',
        'whatsapp',
        'status'
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    // Add relationship to agent
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    // Status constants for consistent usage
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_PENDING = 'pending';

    public static function statusOptions(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_PENDING => 'Pending',
        ];
    }

    public function dailyRecords()
    {
        return $this->hasMany(DailyRecord::class);
    }
}
