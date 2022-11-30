<x-layout>
    <div class="my-2 text-2xl font-bold text-center">
        <h1>Matches en direct</h1>
    </div>

    <div class="overflow-x-auto w-full mb-16">
        <table class="table table-compact w-full">
            <thead>
                <tr>
                    <th>Rouge</th>
                    <th>Bleu</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($directMatches as $directMatch)
                    <tr class="hover hover:cursor-pointer"
                        onclick="window.location.href='{{ route('directmatches.showDirectMatche', $directMatch) }}'">
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="flex items-center	">
                                        <span class="material-symbols-outlined">
                                            swords
                                        </span>
                                        <div class="font-bold">
                                            <span
                                                class="text-red-700 {{ $directMatch->match()->red_score > $directMatch->match()->blue_score ? 'animate-text' : '' }}">
                                                {{ $directMatch->match()->red_front_player() != null ? $directMatch->match()->red_front_player()->username : $directMatch->match()->red_back_player()->username }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center	">
                                        <span class="material-symbols-outlined">
                                            security
                                        </span>
                                        <div class="font-bold">
                                            <span
                                                class="text-red-700 {{ $directMatch->match()->red_score > $directMatch->match()->blue_score ? 'animate-text' : '' }}">
                                                {{ $directMatch->match()->red_back_player() != null ? $directMatch->match()->red_back_player()->username : $directMatch->match()->red_front_player()->username }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="flex items-center	">
                                        <span class="material-symbols-outlined">
                                            swords
                                        </span>
                                        <div class="font-bold">
                                            <span
                                                class="text-red-700 {{ $directMatch->match()->red_score > $directMatch->match()->blue_score ? 'animate-text' : '' }}">
                                                {{ $directMatch->match()->blue_front_player() != null ? $directMatch->match()->blue_front_player()->username : $directMatch->match()->blue_back_player()->username }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center	">
                                        <span class="material-symbols-outlined">
                                            security
                                        </span>
                                        <div class="font-bold">
                                            <span
                                                class="text-red-700 {{ $directMatch->match()->red_score > $directMatch->match()->blue_score ? 'animate-text' : '' }}">
                                                {{ $directMatch->match()->blue_back_player() != null ? $directMatch->match()->blue_back_player()->username : $directMatch->match()->blue_front_player()->username }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $directMatch->match()->red_score < 0 ? '(' . $directMatch->match()->red_score . ')' : $directMatch->match()->red_score }}
                            -
                            {{ $directMatch->match()->blue_score < 0 ? '(' . $directMatch->match()->blue_score . ')' : $directMatch->match()->blue_score }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
