<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Quadrants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quadrants', function (Blueprint $table){
            $table -> increments('id');
            $table -> integer('game');
            $table -> integer('Klingons');
            $table -> integer('Stars');
            $table -> integer('Starbases');
            $table -> integer('X');
            $table -> integer('Y');
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quadrants');
        //
    }
}
