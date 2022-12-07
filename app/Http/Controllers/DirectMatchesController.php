<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DirectSoccerMatch;
use App\Models\SoccerMatch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DirectMatchesController extends Controller
{

    public function showDirectMatches()
    {
        $matches = DirectSoccerMatch::where('ended_at', null)->get();
        return view('directmatches', ['directMatches' => $matches]);
    }

    public function showDirectMatche($id)
    {
        $directMatch = DirectSoccerMatch::find($id);
        return view('directmatch', ['directMatch' => $directMatch]);
    }

    public function init()
    {
        $players = User::all();
        return view('adddirectmatch', ['players' => $players]);
    }

    public function create(Request $request)
    {
        $players = $request->all();
        $validated = $request->validate([
            'red_back_player_id' => ['required_if:red_front_player_id,null', 'integer', 'exists:users,id', function ($attribute, $value, $fail) {
                if (str_starts_with($value, auth()->id())) {
                    $fail('You cannot referee a game while being a player');
                }
            }],
            'red_front_player_id' => ['required_if:red_back_player_id,null', 'integer', 'exists:users,id', function ($attribute, $value, $fail) {
                if (str_starts_with($value, auth()->id())) {
                    $fail('You cannot referee a game while being a player');
                }
            }],
            'blue_back_player_id' => ['required_if:blue_front_player_id,null', 'integer', 'exists:users,id', 'different:red_back_player_id', 'different:red_front_player_id', function ($attribute, $value, $fail) {
                if (str_starts_with($value, auth()->id())) {
                    $fail('You cannot referee a game while being a player');
                }
            }],
            'blue_front_player_id' => ['required_if:blue_back_player_id,null', 'integer', 'exists:users,id', 'different:red_back_player_id', 'different:red_front_player_id', function ($attribute, $value, $fail) {
                if (str_starts_with($value, auth()->id())) {
                    $fail('You cannot referee a game while being a player');
                }
            }],
        ]);

        $match = SoccerMatch::create([
            'red_back_player_id' => $request->input('red_back_player_id') == null ? $request->input('red_front_player_id') : $request->input('red_back_player_id'),
            'red_front_player_id' => $request->input('red_front_player_id') == null ? $request->input('red_back_player_id') : $request->input('red_front_player_id'),
            'blue_back_player_id' => $request->input('blue_back_player_id') == null ? $request->input('blue_front_player_id') : $request->input('blue_back_player_id'),
            'blue_front_player_id' => $request->input('blue_front_player_id') == null ? $request->input('blue_back_player_id') : $request->input('blue_front_player_id'),
            'red_score' => 0,
            'blue_score' => 0,
            'adder_id' => auth()->id(),
        ]);
        $directMatch = DirectSoccerMatch::create([
            'soccer_match_id' => $match->id,
        ]);
        return redirect()->route('directmatches.showDirectMatche', $directMatch->id);
    }

    public function update(Request $request, $id)
    {
        $directMatch = DirectSoccerMatch::find($id);
        if ($request->has('start')) {
            $directMatch->started_at = now();
            $directMatch->save();
        } else if ($request->has('end')) {
            $directMatch->ended_at = now();
            $directMatch->save();

            // Retrieve the soccer match bets
            $status = $directMatch->match()->blue_score > $directMatch->match()->red_score ?
                'blue' : ($directMatch->match()->red_score > $directMatch->match()->blue_score ? 'red' : 'draw');

            $coinsPool = $directMatch->bets()->sum('coins');
            $coinsPool *= 1.3;
            $winnedBets = $directMatch->bets()->where('bet', $status);
            $winnersPool = $winnedBets->sum('coins');
            foreach ($winnedBets->get() as $winnedBet) {
                $user = $winnedBet->player();
                $user->coins += round($coinsPool * ($winnedBet->coins / $winnersPool));
                $user->save();
            }
        } else if ($request->has('delete')) {
            $directMatch->match()->delete();
            return redirect()->route('directmatches.showDirectMatches');
        } else if ($request->has('addAction')) {
            // Verifie si le joueur est bien dans la partie
            $validated = $request->validate([
                'player_id' => ['required', 'integer', 'exists:users,id', function ($attribute, $value, $fail) use ($directMatch) {
                    if ($value != $directMatch->match()->red_back_player_id && $value != $directMatch->match()->red_front_player_id && $value != $directMatch->match()->blue_back_player_id && $value != $directMatch->match()->blue_front_player_id) {
                        $fail('The player is not in the match');
                    }
                }],
                'action' => ['required', 'string', 'max:255'],
                'points' => ['required', 'integer'],
            ]);

            $directMatch->actions()->create([
                'direct_soccer_match_id' => $directMatch->id,
                'player_id' => $request->input('player_id'),
                'action' => $request->input('action'),
                'points' => $request->input('points'),
            ]);
            $match = $directMatch->match();
            if (
                $request->input('points') >= 0 ? $match->red_back_player_id == $request->input('player_id')
                || $match->red_front_player_id == $request->input('player_id') : !($match->red_back_player_id == $request->input('player_id')
                    || $match->red_front_player_id == $request->input('player_id'))
            ) {
                $match->red_score += $request->input('points');
            } else {
                $match->blue_score += $request->input('points');
            }
            $match->save();
        }

        return redirect()->route('directmatches.showDirectMatche', $directMatch);
    }

    public function bet(Request $request, $id)
    {
        $directMatch = DirectSoccerMatch::find($id);

        // Verifie si le match n'a pas déjà commencé, si le joueur n'a pas déjà parié et si le nombre de coins parié est supérieur à 0
        $validated = $request->validate([
            'bet' => ['required', 'string', 'max:255'],
            'coins' => ['required', 'integer', 'min:1', function ($attribute, $value, $fail) use ($directMatch) {
                if ($directMatch->started_at != null && Carbon::parse($directMatch->started_at)->diffInSeconds(Carbon::now()) > 60) {
                    $fail('The match has already started');
                }
                if ($directMatch->bets()->get()->where('player_id', auth()->id())->count() > 0) {
                    $fail('You have already bet on this match');
                }
                if (auth()->user()->coins < $value) {
                    $fail('You do not have enough coins');
                }
            }],
        ]);

        // Retire les coins du joueur
        $user = auth()->user();
        $user->coins -= $request->input('coins');
        $user->save();

        // Ajoute le pari
        $directMatch->bets()->create([
            'player_id' => auth()->id(),
            'soccer_match_id' => $directMatch->match()->id,
            'bet' => $request->input('bet'),
            'coins' => $request->input('coins'),
        ]);


        return redirect()->route('directmatches.showDirectMatche', $directMatch);
    }
}
