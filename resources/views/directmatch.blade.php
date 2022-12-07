<x-layout>
    <div class="my-2 text-xl font-bold text-center">
        <h1>Match en Direct</h1>
    </div>
    @if ($directMatch->started_at != null)
        @if ($directMatch->ended_at == null)
            {{-- <p>Temps passé depuis le début du match : {{ gmdate('i\ms\s',\Carbon\Carbon::parse($directMatch->started_at)->diffInSeconds(\Carbon\Carbon::now())) }}</p> --}}
            <div class="my-2 text-sm font-bold text-center">
                <p>Temps passé depuis le début du match : </p>
            </div>
            <div class="flex justify-center">
                <div class="badge badge-secondary py-4">
                    <span class="material-symbols-outlined">
                        timer
                    </span>
                    <span class="countdown font-mono text-xl h-4">
                        <span id="hours" style="--value:;"></span>h
                        <span id="minutes" style="--value:;"></span>m
                        <span id="seconds" style="--value:;"></span>s
                    </span>
                </div>
            </div>

            <script>
                setInterval(function() {
                    var timePassed = new Date(new Date().getTime() - new Date("{{ $directMatch->started_at }}").getTime() -
                        7200000);
                    var hours = timePassed.getHours();
                    var minutes = timePassed.getMinutes();
                    var seconds = timePassed.getSeconds();
                    document.getElementById("hours").style.setProperty("--value", hours);
                    document.getElementById("minutes").style.setProperty("--value", minutes);
                    document.getElementById("seconds").style.setProperty("--value", seconds);
                }, 1000);
            </script>
        @else
            <div class="my-2 text-sm font-bold text-center">
                <p>Le match est terminé</p>
            </div>
        @endif
    @else
        <div class="my-2 text-sm font-bold text-center">
            <p>Le match n'a pas encore débuté</p>
        </div>
    @endif
    <div class="my-6 text-sm font-bold text-center">
        <p>Score</p>
    </div>
    <div class="flex justify-center">
        <div class="stats shadow">

            <div class="stat flex">
                <div class="flex items-center space-x-3">
                    <div>
                        <div class="flex items-center	">
                            <span class="material-symbols-outlined">
                                swords
                            </span>
                            <div class="font-bold">
                                <p
                                    class="text-red-700 {{ $directMatch->match()->red_score > $directMatch->match()->blue_score ? 'animate-text' : '' }}">
                                    {{ $directMatch->match()->red_front_player()->username }}</p>
                            </div>
                        </div>
                        <div class="flex items-center	">
                            <span class="material-symbols-outlined">
                                security
                            </span>
                            <div class="font-bold">
                                <p
                                    class="text-red-700 {{ $directMatch->match()->red_score > $directMatch->match()->blue_score ? 'animate-text' : '' }}">
                                    {{ $directMatch->match()->red_back_player()->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stat-value">{{ $directMatch->match()->red_score }} -
                    {{ $directMatch->match()->blue_score }}</div>
                <div class="flex items-center space-x-3">
                    <div>
                        <div class="flex items-center	">
                            <span class="material-symbols-outlined">
                                swords
                            </span>
                            <div class="font-bold">
                                <p
                                    class="text-blue-700 {{ $directMatch->match()->blue_score > $directMatch->match()->red_score ? 'animate-text' : '' }}">
                                    {{ $directMatch->match()->blue_front_player()->username }}</p>
                            </div>
                        </div>
                        <div class="flex items-center	">
                            <span class="material-symbols-outlined">
                                security
                            </span>
                            <div class="font-bold">
                                <p
                                    class="text-blue-700 {{ $directMatch->match()->blue_score > $directMatch->match()->red_score ? 'animate-text' : '' }}">
                                    {{ $directMatch->match()->blue_back_player()->username }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-6 mb-2 text-sm font-bold text-center">
        <p>Arbitré par</p>
        <p> {{ $directMatch->match()->added_by()->username }}</p>
    </div>
    <div class="avatar flex justify-center">
        <div class="w-16 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
            <img src="https://cdn.discordapp.com/avatars/{{ $directMatch->match()->added_by()->id }}/{{ $directMatch->match()->added_by()->avatar }}.webp"
                alt="">
        </div>
    </div>

    <!-- Check if user is match adder -->
    @if (Auth::user() != null && Auth::user()->id == $directMatch->match()->added_by()->id)
        <div class="mt-6 mb-2 text-sm font-bold text-center">
            <p>Actions</p>
        </div>
        @if ($errors->any())
            <div class="alert alert-error shadow-lg flex flex-col">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div><span><strong>Whoops!</strong> There were some problems with your input.</span></div>
                </div>
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if ($directMatch->started_at != null && $directMatch->ended_at == null)
            <div class="border-2 rounded border-green-400 m-6 p-3">
                <form action="{{ route('directmatches.update', $directMatch->id) }}" method="POST">
                    @csrf
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text">Séléctionnez le joueur</span>
                        </label>
                        <select name="player_id" class="select select-warning w-full max-w-xs">
                            <option value="" selected disabled>Choisir un joueur</option>
                            @if ($directMatch->match()->red_front_player_id != null)
                                <option value="{{ $directMatch->match()->red_front_player()->id }}">
                                    {{ $directMatch->match()->red_front_player()->username }}</option>
                            @endif
                            @if ($directMatch->match()->red_back_player_id != null &&
                                $directMatch->match()->red_back_player_id != $directMatch->match()->red_front_player_id)
                                <option value="{{ $directMatch->match()->red_back_player()->id }}">
                                    {{ $directMatch->match()->red_back_player()->username }}</option>
                            @endif
                            @if ($directMatch->match()->blue_front_player_id != null)
                                <option value="{{ $directMatch->match()->blue_front_player()->id }}">
                                    {{ $directMatch->match()->blue_front_player()->username }}</option>
                            @endif
                            @if ($directMatch->match()->blue_back_player_id != null &&
                                $directMatch->match()->blue_back_player_id != $directMatch->match()->blue_front_player_id)
                                <option value="{{ $directMatch->match()->blue_back_player()->id }}">
                                    {{ $directMatch->match()->blue_back_player()->username }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text">Séléctionnez le type d'action</span>
                        </label>
                        <select name="action" class="select select-secondary w-full max-w-xs">
                            <option value="" selected disabled>Choisir une action</option>
                            <option value="goal">But</option>
                            <option value="gamelle">Gamelle</option>
                            <option value="topbar">Dessus de barre</option>
                        </select>
                    </div>
                    <div class="form-control w-full max-w-xs">
                        <label class="label">
                            <span class="label-text">Nombre de points à ajouter</span>
                        </label>
                        <input type="number" name="points" placeholder="Entrez un nombre de points"
                            class="input input-bordered input-primary w-full max-w-xs" value="1" />
                    </div>
                    <div class="my-4 flex justify-center">
                        <button type="submit" name="addAction" class="btn btn-outline btn-error">Ajouter</button>
                    </div>
                </form>
            </div>
        @endif
        <form class="my-4 flex justify-center gap-4" action="{{ route('directmatches.update', $directMatch->id) }}"
            method="POST">
            @csrf
            @if ($directMatch->started_at == null)
                <button name="start" type="submit" class="btn btn-outline btn-primary">Démarrer le match</button>
                <button name="delete" type="submit" class="btn btn-outline btn-primary">Supprimer le match</button>
            @elseif ($directMatch->ended_at == null)
                <button name="end" type="submit" class="btn btn-outline btn-primary">Terminer le match</button>
            @else
                <button name="delete" type="submit" class="btn btn-outline btn-primary">Supprimer le match</button>
            @endif
        </form>
    @endif

    <div class="mt-6 mb-2 text-sm font-bold text-center">
        <p>Actions</p>
    </div>

    <div class="overflow-x-auto w-full mb-6">
        <table class="table table-compact w-full">
            <thead>
                <tr>
                    <th>Temps</th>
                    <th>Équipe</th>
                    <th>Joueur</th>
                    <th>Action</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                @if ($directMatch->actions()->orderBy('created_at', 'desc')->count() > 0)
                    @foreach ($directMatch->actions()->orderBy('created_at', 'desc')->get() as $action)
                        <tr class="hover">
                            <td>{{ gmdate('i\ms\s', \Carbon\Carbon::parse($action->created_at)->diffInSeconds(\Carbon\Carbon::now())) }}
                            </td>
                            <td>{{ $action->player()->id == $directMatch->match()->red_front_player_id || $action->player()->id == $directMatch->match()->red_back_player_id ? 'Rouge' : 'Bleu' }}
                            </td>
                            <td>{{ $action->player()->username }}</td>
                            <td>{{ $action->action }}</td>
                            <td>{{ $action->points }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">Aucune action</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-6 mb-2 text-sm font-bold text-center">
        <p>Pari</p>
    </div>
    <!-- Affiche tous les pari dans un tableau ainsi que la cagnotte totale de coins -->
    <div class="flex flex-col items-center gap-4">
        <button class="btn gap-2">
            <span class="material-symbols-outlined">
                savings
            </span>
            <p>Cagnotte: {{ $directMatch->bets()->sum('coins') }}</p>
            <span class="material-symbols-outlined">
                monetization_on
            </span>
            <div class="badge badge-secondary"> + 30% de bonus</div>
        </button>

        @if ($directMatch->hasBet(Auth::user()->id))
            <div class="badge badge-success gap-2 p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Vous avez parié {{ $directMatch->bet(Auth::user()->id)->coins }}
                <span class="material-symbols-outlined">
                    monetization_on
                </span>
                sur
                {{ $directMatch->bet(Auth::user()->id)->bet() }}
            </div>
        @else
            <label for="bet-modal" class="btn">Parier</label>
        @endif
    </div>

    <div class="overflow-x-auto w-full mt-6 mb-20">
        <table class="table table-compact w-full">
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Pari</th>
                    <th>Coins misés</th>
                </tr>
            </thead>
            <tbody>
                @if ($directMatch->bets()->count() > 0)
                    @foreach ($directMatch->bets()->orderBy('coins', 'desc')->get() as $bet)
                        <tr>
                            <td><a
                                    href="{{ route('players.showPlayer', $bet->player()->id) }}">{{ $bet->player()->username }}</a>
                            </td>
                            <td>{{ $bet->bet() }}</td>
                            <td>{{ $bet->coins }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">Aucun pari</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <input type="checkbox" id="bet-modal" class="modal-toggle" {{ $errors->any() ? 'checked' : '' }} />
    <label for="bet-modal" class="modal cursor-pointer">
        <label class="modal-box relative" for="">
            @if ($errors->any())
                <div class="alert alert-error shadow-lg flex flex-col">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div><span><strong>Whoops!</strong> There were some problems with your input.</span></div>
                    </div>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if (($directMatch->started_at == null ||
                \Carbon\Carbon::parse($directMatch->started_at)->diffInSeconds(\Carbon\Carbon::now()) <= 60) &&
                !$directMatch->hasBet(Auth::user()->id) &&
                Auth::user()->id != $directMatch->match()->added_by()->id)
                <form action="{{ route('directmatches.bet', $directMatch->id) }}" method="POST">
                    @csrf
                    <div class="flex flex-col items-center">
                        <div class="form-control w-full max-w-xs">
                            <label class="label">
                                <span class="label-text">Séléctionnez un pari</span>
                            </label>
                            <select name="bet" class="select select-info w-full max-w-xs">
                                <option value="" selected disabled>Choisir un pari</option>
                                <option value="red" {{ old('bet') == 'red' ? 'selected' : '' }}>Victoire Rouge
                                </option>
                                <option value="blue" {{ old('bet') == 'blue' ? 'selected' : '' }}>Victoire Bleu
                                </option>
                                <option value="draw" {{ old('bet') == 'draw' ? 'selected' : '' }}>Matche Nul
                                </option>
                            </select>
                        </div>
                        <div class="form-control w-full max-w-xs">
                            <label class="label">
                                <span name="points" class="label-text">Entrez une somme à parier</span>
                            </label>
                            <input name="coins" type="number" placeholder="Entrez un nombre de points"
                                class="input input-bordered input-primary w-full max-w-xs"
                                value="{{ old('coins') != null ? old('coins') : 1 }}" />
                        </div>
                        <button type="submit" class="btn btn-outline btn-accent mt-6">Parier</button>
                    </div>
                </form>
            @else
                @if (Auth::user()->id == $directMatch->match()->added_by()->id)
                    <div class="alert alert-warning shadow-lg flex flex-col">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div><span>Vous ne pouvez pas parier sur un match que vous arbitrez.</span></div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning shadow-lg flex flex-col">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div><span>Le match a commencé depuis plus d'une minute, vous ne pouvez plus parier.</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </label>
    </label>
</x-layout>
