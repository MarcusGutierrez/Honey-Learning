<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStampForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::table('sessions', function (Blueprint $table){
            $table->dropForeign('sessions_user_id_foreign');
            $table->foreign('user_id')
                    ->references('id')->on('turk_user')
                    ->onDelete('cascade');
        });
        Schema::table('section_stamp', function (Blueprint $table) {
            $table->dropForeign('section_stamp_user_id_foreign');
            $table->foreign('user_id')
                    ->references('id')->on('turk_user')
                    ->onDelete('cascade');
        });
        Schema::table('answer', function (Blueprint $table) {
            $table->dropForeign('answer_user_id_foreign');
            $table->foreign('user_id')
                    ->references('id')->on('turk_user')
                    ->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
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
