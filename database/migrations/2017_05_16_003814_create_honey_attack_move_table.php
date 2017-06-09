<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoneyAttackMoveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honey_attack_move', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('user_id', 65);
            $table->integer('game_id');
            $table->integer('instance');
            $table->integer('round');
            $table->integer('node_id');
            $table->integer('attacker_points');
            $table->integer('defender_points');
            $table->boolean('triggered_honeypot');
            $table->datetime('move_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('honey_attack_move');
    }
}
