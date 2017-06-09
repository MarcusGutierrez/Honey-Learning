<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('honey_game', function (Blueprint $table) {
            $table->primary('gid');
        });
        Schema::table('honey_attack_move', function (Blueprint $table) {
            $table->unique(array('user_id', 'game_id', 'instance', 'round'));
            $table->foreign('user_id')
                    ->references('user_id')->on('users')
                    ->onDelete('cascade');
            $table->foreign('game_id')
                    ->references('gid')->on('honey_game')
                    ->onDelete('cascade');
        });
        Schema::table('honey_node', function (Blueprint $table) {
            $table->unique(array('nid', 'gid'));
            $table->foreign('gid')
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
        $table->dropUnique(array('user_id', 'game_id', 'instance', 'round'));
        $table->dropForeign('user_id');
        $table->dropForeign('game_id');
    }
}
