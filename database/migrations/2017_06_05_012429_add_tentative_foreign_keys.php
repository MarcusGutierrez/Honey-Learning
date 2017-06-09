<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTentativeForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('honey_attack_tentative', function (Blueprint $table) {
            $table->unique(array('user_id', 'game_id', 'instance', 'round', 'move_time'));
            $table->foreign('user_id')
                    ->references('user_id')->on('users')
                    ->onDelete('cascade');
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
        //
    }
}
