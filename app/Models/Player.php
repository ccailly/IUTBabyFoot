<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class Player extends User
{

    protected $table = 'users';

    public function points()
    {
        return max($this->wins()->count() * 3 + $this->draws()->count() - $this->losses()->count() * 2, 0);
    }

    public function matches()
    {
        return DB::table('soccer_matches')->where(function ($query) {
            $query->where('red_back_player_id', $this->id)
                ->orWhere('red_front_player_id', $this->id)
                ->orWhere('blue_back_player_id', $this->id)
                ->orWhere('blue_front_player_id', $this->id);
        });
    }

    public function wins()
    {
        return $this->matches()->where(function ($query) {
            $query->where('red_back_player_id', $this->id)
                ->orWhere('red_front_player_id', $this->id);
        })->whereColumn('red_score', '>', 'blue_score')->orWhere(function ($query) {
            $query->where('blue_back_player_id', $this->id)
                ->orWhere('blue_front_player_id', $this->id);
        })->whereColumn('blue_score', '>', 'red_score');
    }

    public function losses()
    {
        return $this->matches()->where(function ($query) {
            $query->where('red_back_player_id', $this->id)
                ->orWhere('red_front_player_id', $this->id);
        })->whereColumn('red_score', '<', 'blue_score')->orWhere(function ($query) {
            $query->where('blue_back_player_id', $this->id)
                ->orWhere('blue_front_player_id', $this->id);
        })->whereColumn('blue_score', '<', 'red_score');
    }

    public function draws()
    {
        return $this->matches()->where(function ($query) {
            $query->where('red_back_player_id', $this->id)
                ->orWhere('red_front_player_id', $this->id);
        })->whereColumn('red_score', '=', 'blue_score')->orWhere(function ($query) {
            $query->where('blue_back_player_id', $this->id)
                ->orWhere('blue_front_player_id', $this->id);
        })->whereColumn('blue_score', '=', 'red_score');
    }

    public function goals()
    {
        return $this->matches()->where(function ($query) {
            $query->where('red_front_player_id', $this->id)->orWhere('red_back_player_id', $this->id);
        })->where('red_score', '>', 0)->sum('red_score') + $this->matches()->where(function ($query) {
            $query->where('blue_front_player_id', $this->id)->orWhere('blue_back_player_id', $this->id);
        })->where('blue_score', '>', 0)->sum('blue_score');
    }

    public function goalsAgainst()
    {
        return $this->matches()->where(function ($query) {
            $query->where('red_front_player_id', $this->id)->orWhere('red_back_player_id', $this->id);
        })->where('blue_score', '>', 0)->sum('blue_score') + $this->matches()->where(function ($query) {
            $query->where('blue_front_player_id', $this->id)->orWhere('blue_back_player_id', $this->id);
        })->where('red_score', '>', 0)->sum('red_score');
    }

    public function bets()
    {
        return $this->hasMany(DirectSoccerMatchBet::class, 'player_id');
    }
}
