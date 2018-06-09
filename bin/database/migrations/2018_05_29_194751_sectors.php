<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sectors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sectors', function (Blueprint $table){
            $table -> increments('id');
            $table -> integer('quadrant');
            $table -> char('type');
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
        Schema::drop('sectors');
        //
    }
}
