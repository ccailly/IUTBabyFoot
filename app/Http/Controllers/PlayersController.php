<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SoccerMatch;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function showPlayers()
    {
        $players = Player::all();
        return view('players', ['players' => $players]);
    }

    public function showPlayer($id)
    {
        $player = Player::find($id);
        return view('player', ['player' => $player]);
    }
}
