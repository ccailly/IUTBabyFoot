<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->string('description');
            $table->string('unicode');
            $table->timestamps();
        });

        DB::table('badges')->insert([
            [
                'name' => 'bronze',
                'display_name' => 'Bronze',
                'description' => 'Ce badge est délivré au 3ème meilleur joueur du site.\n{name} est classé 3ème sur {total} joueurs.',
                'unicode' => '🥉',
            ],
            [
                'name' => 'silver',
                'display_name' => 'Silver',
                'description' => 'Ce badge est délivré au 2ème meilleur joueur du site.\n{name} est classé 2ème sur {total} joueurs.',
                'unicode' => '🥈',
            ],
            [
                'name' => 'gold',
                'display_name' => 'Gold',
                'description' => 'Ce badge est délivré au meilleur joueur du site.\n{name} est classé 1er sur {total} joueurs.',
                'unicode' => '🥇',
            ],
            [
                'name' => 'poop',
                'display_name' => 'Poop',
                'description' => 'Ce badge est délivré au pire joueur du site.\n{name} est classé dernier sur {total} joueurs.',
                'unicode' => '💩',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badges');
    }
};
