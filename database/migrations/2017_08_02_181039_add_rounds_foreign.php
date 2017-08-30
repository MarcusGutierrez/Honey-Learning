<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundsForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('honey_attack_move', function (Blueprint $table) {
            $table->unique(array('round_id', 'attack_attempt', 'move_time'), 'attack_move_primary');
            $table->foreign('round_id')
                    ->references('round_id')->on('round')
                    ->onDelete('cascade');
        });
        Schema::table('honey_attack_tentative', function (Blueprint $table) {
            $table->unique(array('round_id', 'attack_attempt', 'move_time'), 'attack_tentative_primary');
            $table->foreign('round_id')
                    ->references('round_id')->on('round')
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
