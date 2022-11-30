<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoccerMatch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'red_back_player_id',
        'red_front_player_id',
        'blue_back_player_id',
        'blue_front_player_id',
        'red_score',
        'blue_score',
        'adder_id',
    ];


    /**
     * Retourne le nom de la team rouge.
     * Par defaut le nom de la team est le nom des joueurs de la team rouge, si un des joueurs est nul, ne pas afficher.
     * Si les deux joueurs sont le meme, retourner le nom du joueur.
     * 
     * @return string
     */
    public function red_team_name()
    {
        $red_back_player = $this->red_back_player();
        $red_front_player = $this->red_front_player();

        if ($red_back_player && $red_front_player) {
            if ($red_back_player->id === $red_front_player->id) {
                return $red_back_player->username;
            } else {
                return $red_back_player->username . ' & ' . $red_front_player->username;
            }
        } else if ($red_back_player) {
            return $red_back_player->username;
        } else if ($red_front_player) {
            return $red_front_player->username;
        } else {
            return 'Team Rouge';
        }
    }

    /**
     * Retourne le nom de la team bleue.
     * Par defaut le nom de la team est le nom des joueurs de la team bleue, si un des joueurs est nul, ne pas afficher.
     * Si les deux joueurs sont le meme, retourner le nom du joueur.
     * 
     * @return string
     */
    public function blue_team_name()
    {
        $blue_back_player = $this->blue_back_player();
        $blue_front_player = $this->blue_front_player();

        if ($blue_back_player && $blue_front_player) {
            if ($blue_back_player->id === $blue_front_player->id) {
                return $blue_back_player->username;
            } else {
                return $blue_back_player->username . ' & ' . $blue_front_player->username;
            }
        } else if ($blue_back_player) {
            return $blue_back_player->username;
        } else if ($blue_front_player) {
            return $blue_front_player->username;
        } else {
            return 'Team bleue';
        }
    }

    /**
     * Get the red back player.
     */
    public function red_back_player()
    {
        return $this->belongsTo(User::class, 'red_back_player_id')->first();
    }

    /**
     * Get the red front player.
     */
    public function red_front_player()
    {
        return $this->belongsTo(User::class, 'red_front_player_id')->first();
    }

    /**
     * Get the blue back player.
     */
    public function blue_back_player()
    {
        return $this->belongsTo(User::class, 'blue_back_player_id')->first();
    }

    /**
     * Get the blue front player.
     */
    public function blue_front_player()
    {
        return $this->belongsTo(User::class, 'blue_front_player_id')->first();
    }

    /**
     * Get the adder.
     */
    public function added_by()
    {
        return $this->belongsTo(User::class, 'adder_id')->first();
    }

    /**
     * Check if is a direct.
     */
    public function is_direct()
    {
        return $this->hasOne(DirectSoccerMatch::class, 'soccer_match_id')->count() > 0;
    }

    /**
     * Get the direct soccer match.
     */
    public function direct_match()
    {
        return $this->hasOne(DirectSoccerMatch::class, 'soccer_match_id')->first();
    }
}
