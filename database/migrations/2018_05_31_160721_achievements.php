<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Achievements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table){
            $table -> increments('id');
            $table -> integer('user');
            $table -> integer('game');
            $table -> integer('quadrant');
            $table -> string('achievement');
            $table -> integer('value');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('achievements');
    }
}
