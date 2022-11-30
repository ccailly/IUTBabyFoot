<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectSoccerMatchBet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'player_id',
        'soccer_match_id',
        'bet',
        'coins',
    ];

    /**
     * Get the player.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id')->first();
    }

    /**
     * Get the direct soccer match.
     */
    public function directMatch()
    {
        return $this->belongsTo(DirectSoccerMatch::class, 'soccer_match_id')->first();
    }

    /**
     * Get the soccer match.
     */
    public function match()
    {
        return $this->directMatch()->match();
    }

    /**
     * Get stylized bet name.
     */
    public function bet()
    {
        switch ($this->bet) {
            case 'blue':
                return 'Victoire Bleu';
            case 'red':
                return 'Victoire Rouge';
            case 'draw':
                return 'Match Nul';
            default:
                return 'Erreur';
        }
    }

    /**
     * Retourne le gain de ce pari, 0 si le pari n'est pas gagnant et nul si le match n'est pas terminé
     * Un bonus de 30% est appliqué si le pari est gagnant
     */
    public function gain()
    {
        if ($this->directMatch()->ended_at == null) {
            return null;
        }

        // Récupère l'issue du match
        $status = $this->match()->red_score > $this->match()->blue_score ? 'red' : ($this->match()->red_score < $this->match()->blue_score ? 'blue' : 'draw');
        if ($status == $this->bet) {
            return $this->coins * 1.3;
        }

        return 0;
    }
}
