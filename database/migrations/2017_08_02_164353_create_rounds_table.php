<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('round_id');
            $table->integer('session_id')->unsigned();
            $table->integer('network_id')->unsigned();
            $table->integer('round_number');
            $table->string('defender_move', 20);
            $table->string('round_start', 26)->nullable();
            $table->string('round_end', 26)->nullable();
        });
        Schema::table('round', function (Blueprint $table) {
            $table->unique(array('session_id', 'network_id', 'round_number'));
            $table->foreign('session_id')
                    ->references('session_id')->on('sessions')
                    ->onDelete('cascade');
            $table->foreign('network_id')
                    ->references('network_id')->on('honey_network')
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
        Schema::dropIfExists('rounds');
    }
}
