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
            $table->string('user_id', 65);
            $table->integer('game_id');
            $table->integer('instance');
            $table->integer('round');
            $table->datetime('move_time');
            $table->integer('node_id');
            $table->boolean('submitted');
            
            $table->foreign('game_id')
                    ->references('gid')->on('honey_game')
                    ->onDelete('cascade');
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
