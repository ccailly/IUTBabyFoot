<!doctype html>
<html data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <img class="mb-4 h-20 w-full object-cover border-solid border-2 border-sky-500 rounded"
        src="https://raw.githubusercontent.com/kevinrpan/foos-analysis/master/img/foos_banner.jpg">
    <div class="btm-nav bg-gradient-to-r from-red-900 to-blue-900 z-40">
        <a href="{{ route('players.showPlayers') }}"
            class="{{ Route::currentRouteName() == 'players.showPlayers' ? 'active' : '' }}">
            <span class="material-symbols-outlined">
                star
            </span>
        </a>
        <a href="{{ route('matches.showMatches') }}"
            class="{{ Route::currentRouteName() == 'matches.showMatches' ? 'active' : '' }}">
            <span class="material-symbols-outlined">
                receipt_long
            </span>
        </a>
        <a href="{{ route('directmatches.showDirectMatches') }}"
            class="{{ Route::currentRouteName() == 'directmatches.showDirectMatches' ? 'active' : '' }}">
            <span class="material-symbols-outlined">
                dynamic_form
            </span>
        </a>
        <a href="{{ route('matches.add') }}" class="{{ Route::currentRouteName() == 'matches.add' ? 'active' : '' }}">
            <span class="material-symbols-outlined">
                add
            </span>
        </a>
        <a href="{{ route('directmatches.add') }}"
            class="{{ Route::currentRouteName() == 'directmatches.add' ? 'active' : '' }}">
            <span class="material-symbols-outlined">
                hourglass_top
            </span>
        </a>
        @auth
        <a href="{{ route('players.showPlayer', Auth::user()->id) }}"
            class="{{ Route::currentRouteName() == 'players.showPlayer' ? 'active' : '' }}">
            <span class="material-symbols-outlined">
                account_circle
            </span>
        </a>
        @else
        <a href="{{ route('login') }}"
            class="{{ Route::currentRouteName() == 'players.showPlayer' ? 'active' : '' }}">
            <span class="material-symbols-outlined">
                account_circle
            </span>
        </a>
        @endauth
    </div>
    @guest
        <div class="my-4 alert alert-info shadow-lg">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="stroke-current flex-shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Vous devez être connecté pour acceder aux fonctionnalités.</span>
            </div>
        </div>
        <div class="my-4 flex justify-center">
            <a href="{{ route('login') }}">
                <button class="btn btn-active btn-primary"><span class="material-symbols-outlined">
                        login
                    </span>
                    Se connecter
                </button>
            </a>
        </div>
    @endguest
    {{ $slot }}
    <div class="mt-16"></div>
</body>

</html>
