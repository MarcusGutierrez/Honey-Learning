<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoneyNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honey_node', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('nid');
            $table->integer('gid');
            $table->integer('x_axis');
            $table->integer('y_axis');
            $table->integer('value');
            $table->integer('defender_cost');
            $table->integer('attacker_cost');
            $table->boolean('is_honeypot');
            $table->boolean('is_public');
            $table->float('probability');
            $table->integer('discount');
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
        Schema::dropIfExists('honey_nodes');
    }
}
