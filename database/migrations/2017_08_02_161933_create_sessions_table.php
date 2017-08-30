<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    
    protected $primaryKey = 'session_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('session_id', true);
            $table->string('defender_type', 20);
            $table->integer('user_id')->unsigned();
            $table->boolean('completed')->default(false);
            $table->string('session_start', 26)->default(current_time());
            $table->string('session_end', 26)->nullable();
        });
        Schema::table('sessions', function (Blueprint $table) {
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
        Schema::dropIfExists('sessions');
    }
}
