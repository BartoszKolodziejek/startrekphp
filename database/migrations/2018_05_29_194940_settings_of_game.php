<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsOfGame extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('settings_of_game', function (Blueprint $table){
            $table -> increments('id');
            $table -> integer('torpedoes');
            $table -> integer('energy');
            $table -> integer('shields');

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
        Schema::drop('settings_of_game');
        //
    }
}
