<?php

namespace App\Models;

use App\Models\SoccerMatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DirectSoccerMatch extends SoccerMatch
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'soccer_match_id',
        'started_at',
        'ended_at',
    ];

    /**
     * Get the soccer match that owns the DirectSoccerMatch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo(SoccerMatch::class, 'soccer_match_id')->get()[0];
    }

    /**
     * Get the soccer match actions for the DirectSoccerMatch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany(SoccerMatchAction::class, 'direct_soccer_match_id');
    }

    /**
     * Get the soccer match bets for the DirectSoccerMatch
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bets()
    {
        return $this->hasMany(DirectSoccerMatchBet::class, 'soccer_match_id');
    }

    public function bet($playerId)
    {
        return $this->bets()->get()->where('player_id', $playerId)->first();
    }

    public function hasBet($playerId)
    {
        return $this->bets()->get()->where('player_id', $playerId)->count() > 0;
    }

    public function isStarted()
    {
        return $this->started_at != null || $this->started_at > now();
    }

    public function isEnded()
    {
        return $this->ended_at != null;
    }
}
