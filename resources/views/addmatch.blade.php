<x-layout>
    <div class="my-2 text-xl font-bold text-center">
        <h1>Ajouter un match</h1>
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
    <form action="{{ route('matches.store') }}" method="POST">
        @csrf

        <div class="border-2 rounded border-red-600 m-6 p-3">
            <div class="flex justify-center mb-2">
                <span class="material-symbols-outlined">
                    group
                    </span>
                <legend>Equipe Rouge</legend>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Séléctionnez l'attaquant de l'équipe rouge</span>
                </label>
                <select name="red_front_player_id" class="select select-error w-full max-w-xs">
                    <option value="" selected disabled>Choisir un joueur</option>
                    @foreach ($players as $player)
                        <option value="{{ $player->id }}"
                            {{ $player->id == old('red_front_player_id') ? 'selected' : '' }}>
                            {{ $player->username }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Séléctionnez le défenseur de l'équipe rouge</span>
                </label>
                <select name="red_back_player_id" class="select select-warning w-full max-w-xs">
                    <option value="" selected disabled>Choisir un joueur</option>
                    @foreach ($players as $player)
                        <option value="{{ $player->id }}"
                            {{ $player->id == old('red_back_player_id') ? 'selected' : '' }}>
                            {{ $player->username }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Score rouge</span>
                </label>
                <input type="number" name="red_score" placeholder="Entrez un score"
                    class="input input-bordered input-primary w-full max-w-xs" value="{{ old('red_score') }}" />
            </div>
        </div>


        <div class="border-2 rounded border-blue-600 m-6 p-3">
            <div class="flex justify-center mb-2">
                <span class="material-symbols-outlined">
                    group
                </span>
                <legend>Equipe Bleu</legend>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Séléctionnez l'attaquant de l'équipe bleu</span>
                </label>
                <select name="blue_front_player_id" class="select select-info w-full max-w-xs">
                    <option value="" selected disabled>Choisir un joueur</option>
                    @foreach ($players as $player)
                        <option value="{{ $player->id }}"
                            {{ $player->id == old('blue_front_player_id') ? 'selected' : '' }}>
                            {{ $player->username }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Séléctionnez le défenseur de l'équipe bleu</span>
                </label>
                <select name="blue_back_player_id" class="select select-success w-full max-w-xs">
                    <option value="" selected disabled>Choisir un joueur</option>
                    @foreach ($players as $player)
                        <option value="{{ $player->id }}"
                            {{ $player->id == old('blue_back_player_id') ? 'selected' : '' }}>
                            {{ $player->username }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Score bleu</span>
                </label>
                <input type="number" name="blue_score" placeholder="Entrez un score"
                    class="input input-bordered input-primary w-full max-w-xs" value="{{ old('blue_score') }}" />
            </div>
        </div>
        <div class="my-4 flex justify-center mb-20">
            <button type="submit" class="btn btn-outline btn-success">Ajouter</button>
        </div>
    </form>
</x-layout>
