<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soccer_match_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direct_soccer_match_id')->constrained('direct_soccer_matches')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('player_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('action');
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soccer_match_actions');
    }
};
