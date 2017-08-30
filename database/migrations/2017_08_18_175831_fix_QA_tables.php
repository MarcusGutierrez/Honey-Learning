<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixQATables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::create('question', function (Blueprint $table) {
            $table->increments('question_id');
            $table->integer('question_number');
            $table->string('type', 20);
            $table->string('body', 160);
            $table->unique(array('question_number', 'type'));
            //$table->timestamps();
        });
        Schema::create('answer', function (Blueprint $table) {
            $table->increments('answer_id');
            $table->integer('user_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('body');
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->foreign('question_id')
                    ->references('question_id')->on('questions')
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
