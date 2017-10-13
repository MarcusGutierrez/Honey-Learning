<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionStamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answer', function (Blueprint $table) {
            $table->dropColumn('body');
        });
        Schema::table('answer', function (Blueprint $table) {
            $table->string('body', 30)->nullable();
        });
        Schema::table('sessions', function (Blueprint $table) {
            $table->integer('round_amount');
        });
        Schema::create('section_stamp', function (Blueprint $table) {
            $table->increments('section_id');
            $table->integer('user_id')->unsigned();
            $table->string('section_type', 30);
            $table->string('time_entered', 26)->nullable();
            $table->string('time_completed', 26)->nullable();
            //$table->timestamps();
        });
        Schema::table('section_stamp', function (Blueprint $table) {
            $table->foreign('user_id')
                    ->references('id')->on('users')
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
