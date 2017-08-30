<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoneyAtentativeMoveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honey_attack_tentative', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('move_id');
            //$table->integer('user_id')->unsigned();
            //$table->integer('network_id');
            $table->integer('round_id')->unsigned();
            //$table->integer('session_id')->unsigned();
            $table->integer('attack_attempt');
            $table->string('move_time', 26);
            $table->integer('node_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('honey_attack_tenative');
    }
}
