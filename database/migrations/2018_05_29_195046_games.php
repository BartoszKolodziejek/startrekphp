<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Games extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table){
            $table -> increments('id');
            $table -> string('name');
            $table -> integer('max_number');
            $table -> integer('settings_of_game');
            $table -> timestamp('time_stamp');
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
        Schema::drop('games');
        //
    }
}
