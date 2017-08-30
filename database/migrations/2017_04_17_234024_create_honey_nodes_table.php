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
            $table->integer('node_id');
            $table->integer('network_id')->unsigned();
            $table->integer('x_axis')->default(0);
            $table->integer('y_axis')->default(0);
            $table->integer('value');
            $table->integer('defender_cost');
            $table->integer('attacker_cost');
            $table->boolean('is_honeypot')->default(false);
            $table->boolean('is_public')->default(true);
            $table->float('probability')->default(1.0);
            $table->integer('discount')->default(0);
            //$table->timestamps();
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
