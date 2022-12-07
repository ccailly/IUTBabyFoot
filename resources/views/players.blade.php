<x-layout>
    <div class="my-2 text-2xl font-bold text-center">
        <h1>Classement</h1>
    </div>
    <div class="overflow-x-auto w-full">
        <table class="table table-compact w-full">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Joueur</th>
                    <th>Points</th>
                    <th>Coins</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                    <tr class="hover">
                        <td>#{{ $loop->iteration }}</td>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        @if ($player->avatar != null)
                                            <img
                                                src="https://cdn.discordapp.com/avatars/{{ $player->id }}/{{ $player->avatar }}.webp" />
                                        @else
                                            <img src="https://i.imgur.com/sfVHQq7_d.webp?maxwidth=760&fidelity=grand" />
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <a class="font-bold"
                                        href="{{ route('players.showPlayer', $player) }}">{{ $player->username }}</a>
                                </div>
                            </div>
                        </td>
                        <td>{{ $player->points() }}</td>
                        <td>{{ $player->coins }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</x-layout>
