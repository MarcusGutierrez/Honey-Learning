<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundMoveUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('round', function (Blueprint $table){
            $table->dropUnique('round_unique');
            $table->unique(array('session_id', 'round_number'), 'round_unique');
        });
        Schema::table('honey_attack_move', function (Blueprint $table){
            $table->dropForeign('honey_attack_move_round_id_foreign');
            $table->dropUnique('attack_move_primary');
            
            $table->unique(array('round_id', 'attack_attempt'), 'attack_move_unique');
            
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
