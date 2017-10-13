<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquilibria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equilibria', function (Blueprint $table) {
            $table->increments('equilibria_id');
            $table->integer('network_id')->unsigned();
            $table->string('defender_move', 20);
            $table->double('probability', 17, 17);
        });
        Schema::table('equilibria', function (Blueprint $table) {
            $table->foreign('network_id ')
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
        //
    }
}
