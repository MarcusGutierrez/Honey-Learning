<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCumulativePassedCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('round', function (Blueprint $table){
            $table->integer('cumulative_score');
        });
        Schema::table('honey_attack_move', function (Blueprint $table){
            $table->boolean('passed');
            $table->boolean('timed_out');
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
