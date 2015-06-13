<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('towns', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('state_id')->unsigned();
      $table->foreign('state_id')->references('id')->on('states');
      $table->string('description')->unique();
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
    Schema::drop('towns');
  }

}
