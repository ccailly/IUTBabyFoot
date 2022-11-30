<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoccerMatchAction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'direct_soccer_match_id',
        'player_id',
        'action',
        'points',
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id')->first();
    }
}
