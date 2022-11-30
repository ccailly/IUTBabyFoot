<x-layout>
    <div class="my-2 text-2xl font-bold text-center">
        <h1>Matches</h1>
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
                @foreach ($matches as $match)
                    @if (!$match->is_direct() || $match->direct_match()->ended_at != null)
                        <tr class="hover hover:cursor-pointer" onclick="window.location.href='{{ route('matches.showMatch', $match) }}'">
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <div class="flex items-center">
                                            <span class="material-symbols-outlined">
                                                swords
                                            </span>
                                            <div class="font-bold">
                                                <span
                                                    class="text-red-700 {{ $match->red_score > $match->blue_score ? 'animate-text' : '' }}">
                                                    {{ $match->red_front_player() != null ? $match->red_front_player()->username : $match->red_back_player()->username }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="material-symbols-outlined">
                                                security
                                            </span>
                                            <div class="font-bold">
                                                <span
                                                    class="text-red-700 {{ $match->red_score > $match->blue_score ? 'animate-text' : '' }}">
                                                    {{ $match->red_back_player() != null ? $match->red_back_player()->username : $match->red_front_player()->username }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <div class="flex items-center">
                                            <span class="material-symbols-outlined">
                                                swords
                                            </span>
                                            <div class="font-bold">
                                                <span
                                                    class="text-red-700 {{ $match->red_score > $match->blue_score ? 'animate-text' : '' }}">
                                                    {{ $match->blue_front_player() != null ? $match->blue_front_player()->username : $match->blue_back_player()->username }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="material-symbols-outlined">
                                                security
                                            </span>
                                            <div class="font-bold">
                                                <span
                                                    class="text-red-700 {{ $match->red_score > $match->blue_score ? 'animate-text' : '' }}">
                                                    {{ $match->blue_back_player() != null ? $match->blue_back_player()->username : $match->blue_front_player()->username }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $match->red_score < 0 ? '(' . $match->red_score . ')' : $match->red_score }} -
                                {{ $match->blue_score < 0 ? '(' . $match->blue_score . ')' : $match->blue_score }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
