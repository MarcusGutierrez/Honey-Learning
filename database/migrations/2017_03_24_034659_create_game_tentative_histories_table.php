<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTentativeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_tentative_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->string('user_id');
            $table->integer('round');
            $table->integer('defender_action');
            $table->datetime('time_defender_moved');
            $table->integer('attacker_action');
            $table->datetime('time_attacker_moved');
            $table->integer('defender_points');
            $table->integer('attacker_points');
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
        Schema::dropIfExists('game_tentative_histories');
    }
}
