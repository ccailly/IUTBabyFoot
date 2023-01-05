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
                @foreach ($players->sortBy(
        function ($value, $key) {
            return $value->points();
        },
        SORT_REGULAR,
        true,
    ) as $player)
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
                                @foreach ($player->badges() as $badge)
                                    <label for="my-modal-{{ $loop->iteration }}"
                                        class="btn text-2xl">{{ $badge->unicode }}</label>
                                    <input type="checkbox" id="my-modal-{{ $loop->iteration }}" class="modal-toggle" />
                                    <label for="my-modal-{{ $loop->iteration }}" class="modal cursor-pointer">
                                        <label class="modal-box relative" for="">
                                            <h3 class="text-lg font-bold text-center">{{ $badge->display_name }}</h3>
                                            <h3 class="my-4 text-4xl font-bold text-center">{{ $badge->unicode }}</h3>
                                            <?php
                                            $description = $badge->description;
                                            $description = str_replace('{name}', $player->username, $description);
                                            $description = str_replace('{total}', $players->count(), $description);
                                            $description = str_replace('\n', '<br>', $description);
                                            echo '<p class="my-4 text-center">' . nl2br($description) . '</p>';
                                            ?>
                                        </label>
                                    </label>
                                @endforeach
                        </td>
                        <td>{{ $player->points() }}</td>
                        <td>{{ $player->coins }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</x-layout>