<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class States extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table){
            $table -> increments('id');
            $table -> integer('user');
            $table -> integer('game');
            $table -> integer('energy');
            $table -> integer('shield');
            $table -> integer('torpedoes');
            $table -> integer('quadrant');
            $table -> integer('klingons');
            $table -> integer('stardays');
            $table -> integer('sector');
            $table -> string('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('states');
    }
}
