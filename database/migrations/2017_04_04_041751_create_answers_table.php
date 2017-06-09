<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->integer('Question_1');
            $table->integer('Question_2');
            $table->integer('Question_3');
            $table->integer('Question_4');
            $table->integer('Question_5');
            $table->integer('Question_6');
            $table->integer('Question_7');
            $table->integer('Question_8');
            $table->integer('Question_9');
            $table->integer('Question_10');
            $table->integer('Question_11');
            $table->integer('Question_12');
            $table->integer('Question_13');
            $table->integer('Question_14');
            $table->integer('Question_15');
            $table->integer('Question_16');
            $table->integer('Question_17');
            $table->integer('Question_18');
            $table->integer('Question_19');
            $table->integer('Question_20');
            $table->integer('Question_21');
            $table->integer('Question_22');
            $table->integer('Question_23');
            $table->integer('Question_24');
            $table->integer('Question_25');
            $table->integer('Question_26');
            $table->integer('Question_27');
            



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
