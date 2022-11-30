<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SoccerMatch;
use App\Models\User;
use Illuminate\Http\Request;

class MatchesController extends Controller
{

    public function showMatches()
    {
        $matches = SoccerMatch::all();
        return view('matches', ['matches' => $matches]);
    }

    public function showMatch($id)
    {
        $match = SoccerMatch::find($id);
        return view('match', ['match' => $match]);
    }

    public function add()
    {
        $players = User::all();
        return view('addmatch', ['players' => $players]);
    }

    public function store(Request $request)
    {
        $players = $request->all();
        $validated = $request->validate([
            'red_back_player_id' => ['required_if:red_front_player_id,null', 'integer', 'exists:users,id'],
            'red_front_player_id' => ['required_if:red_back_player_id,null', 'integer', 'exists:users,id'],
            'blue_back_player_id' => ['required_if:blue_front_player_id,null', 'integer', 'exists:users,id', 'different:red_back_player_id', 'different:red_front_player_id'],
            'blue_front_player_id' => ['required_if:blue_back_player_id,null', 'integer', 'exists:users,id', 'different:red_back_player_id', 'different:red_front_player_id'],
            'red_score' => ['required', 'integer', 'max:11'],
            'blue_score' => ['required', 'integer','max:11'],
        ]);

        $match = SoccerMatch::create([
            'red_back_player_id' => $request->input('red_back_player_id'),
            'red_front_player_id' => $request->input('red_front_player_id'),
            'blue_back_player_id' => $request->input('blue_back_player_id'),
            'blue_front_player_id' => $request->input('blue_front_player_id'),
            'red_score' => $request->input('red_score'),
            'blue_score' => $request->input('blue_score'),
            'adder_id' => auth()->id(),
        ]);
        return redirect()->route('matches.showMatches');
    }
}
