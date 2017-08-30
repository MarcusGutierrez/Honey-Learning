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
            $table->increments('move_id');
            //$table->integer('user_id')->unsigned();
            //$table->integer('network_id');
            $table->integer('round_id')->unsigned();
            //$table->integer('session_id')->unsigned();
            $table->integer('attack_attempt');
            $table->integer('node_id');
            $table->integer('attacker_points');
            $table->integer('defender_points');
            $table->boolean('triggered_honeypot');
            $table->string('move_time', 26);
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
