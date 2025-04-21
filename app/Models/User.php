<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'picture',
        'telegram_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function last_activity(){
        $session = DB::table('sessions')
            ->where('user_id', $this->id)
            ->orderBy('last_activity', 'desc')
            ->first();

        if (!$session) {
            return 'Maʼlumot yoʻq';
        }

        $lastActivity = Carbon::createFromTimestamp($session->last_activity);
        $now = now();

        if ($lastActivity->gt($now->subMinutes(1))) {
            return 'Online';
        } elseif ($lastActivity->gt($now->subMinutes(5))) {
            return 'Yaqinda online edi';
        } else {
            return 'Oxirgi marta: ' . $lastActivity->format('d.m.Y H:i');
        }
    }

}
