<x-layout>
    <div class="avatar flex justify-center">
        <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
            <img src="https://cdn.discordapp.com/avatars/{{ $player->id }}/{{ $player->avatar }}.webp" alt="">
        </div>
    </div>
    <div class="my-2 text-xl font-bold text-center">
        <h1>{{ $player->username }}</h1>
    </div>

    <div class="flex justify-center	">
        <div class="badge badge-accent">Inscrit depuis {{ $player->created_at }}</div>
    </div>

    <div class="my-6 text-base font-bold text-center">
        <h1>Statistiques</h1>
    </div>
    <div class="grid grid-cols-3 gap-2 justify-items-center">

        <div class="">
            <div class="stat-title">Points</div>
            <div class="stat-value">{{ $player->points() }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    military_tech
                </span>
            </div>
        </div>

        <div class="radial-progress bg-primary text-primary-content border-4 border-primary"
            style="--value:{{ $player->matches()->count() == 0 ? 0 : round($player->wins()->count() / $player->matches()->count(), 2) * 100 }};">
            <div class="flex flex-col items-center">
                <div>Ratio</div>
                <div>
                    {{ $player->matches()->count() == 0 ? 0 : round($player->wins()->count() / $player->matches()->count(), 2) * 100 }}%
                </div>
            </div>

        </div>

        <div class="">
            <div class="stat-title">Matchs joués</div>
            <div class="stat-value">{{ $player->matches()->count() }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    stadia_controller
                </span>
            </div>
        </div>

        <div class="">
            <div class="stat-title">Matchs gagnés</div>
            <div class="stat-value">{{ $player->wins()->count() }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    done
                </span>
            </div>
        </div>

        <div class="">
            <div class="stat-title">Matchs perdus</div>
            <div class="stat-value">
                {{ $player->losses()->count() }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    close
                </span>
            </div>
        </div>

        <div class="">
            <div class="stat-title">Matchs nuls</div>
            <div class="stat-value">{{ $player->draws()->count() }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    balance
                </span>
            </div>
        </div>

        <div class="">
            <div class="stat-title">Buts marqués</div>
            <div class="stat-value">{{ $player->goals() }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    ads_click
                </span>
            </div>
        </div>

        <div class="">
            <div class="stat-title">Buts encaissés</div>
            <div class="stat-value">{{ $player->goalsAgainst() }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    gpp_bad
                </span>
            </div>
        </div>

        <div class="">
            <div class="stat-title">Moyenne buts</div>
            <div class="stat-value">
                {{ $player->matches()->count() == 0 ? 0 : round($player->goals() / $player->matches()->count(), 2) }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    monitoring
                </span>
            </div>
            <div class="stat-desc">Marqués par match</div>
        </div>

        <div class="mx-auto">
            <div class="stat-title">Moyenne buts</div>
            <div class="stat-value">
                {{ $player->matches()->count() == 0 ? 0 : round($player->goalsAgainst() / $player->matches()->count(), 2) }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    monitoring
                </span>
            </div>
            <div class="stat-desc">Encaissés par match</div>
        </div>

        <div class="">
            <div class="stat-title">Coins</div>
            <div class="stat-value">{{ $player->coins }}
                <span class="stat-figure text-secondary material-symbols-outlined">
                    monetization_on
                </span>
            </div>
        </div>

    </div>

    <div class="mt-12 text-base font-bold text-center">
        <h1>Pari</h1>
    </div>
    <div class="overflow-x-auto my-6">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Match</th>
                    <th>Pari</th>
                    <th>Mise</th>
                    <th>Gain</th>
                </tr>
            </thead>
            <tbody>
                @if ($player->bets()->count() == 0)
                    <tr>
                        <td colspan="4" class="text-center">Aucun pari</td>
                    </tr>
                @endif
                @foreach ($player->bets()->get() as $bet)
                    <tr class="hover">
                        <td>{{ $bet->match()->red_team_name() }} - {{ $bet->match()->blue_team_name() }}</td>
                        <td>{{ $bet->bet() }}</td>
                        <td>{{ $bet->coins }}</td>
                        <td>{{ $bet->gain() != null ? $bet->gain() : 'Match en cours' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <div class="my-4 flex justify-center">
                <button class="btn btn-active btn-primary mb-16"><span class="material-symbols-outlined">
                        logout
                    </span>
                    Se déconnecter
                </button>
            </div>
        </form>
    @endauth
</x-layout>
