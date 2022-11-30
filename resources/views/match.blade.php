<x-layout>
    <fieldset>
        <legend>Informations</legend>
        <p>Victoire : {{ $match->red_score >= $match->blue_score ? $match->red_score == $match->blue_score ? "Égalité" : "Équipe rouge" : "Équipe bleu" }}</p>
        <p>Score: {{ $match->red_score }} - {{ $match->blue_score }}</p>
        <p>Équipe rouge: {{ $match->red_front_player_id == $match->red_back_player_id ? $match->red_front_player()->username : $match->red_front_player()->username . " et " . $match->red_back_player()->username }}</p>
        <p>Équipe bleu: {{ $match->blue_front_player_id == $match->blue_back_player_id ? $match->blue_front_player()->username : $match->blue_front_player()->username . " et " . $match->blue_back_player()->username }}</p>
        <p>Ajouté par: {{ $match->added_by()->username }}</p>
    </fieldset>
</x-layout>