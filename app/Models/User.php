<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'username',
        'coins',
        'discriminator',
        'email',
        'avatar',
        'verified',
        'locale',
        'mfa_enabled',
        'refresh_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'refresh_token',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'username' => 'string',
        'discriminator' => 'string',
        'email' => 'string',
        'avatar' => 'string',
        'verified' => 'boolean',
        'locale' => 'string',
        'mfa_enabled' => 'boolean',
        'refresh_token' => 'encrypted',
    ];

    public function badges($badges = [])
    {
        $user_badges = UserBadge::where('user_id', $this->id)->join('badges', 'badges.id', '=', 'user_badges.badge_id')->get();
        return $user_badges->merge($badges);
    }
}
