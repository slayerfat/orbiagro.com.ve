<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNationalitiesTable extends Migration
{

    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('nationalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->unique();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::drop('nationalities');
    }
}
