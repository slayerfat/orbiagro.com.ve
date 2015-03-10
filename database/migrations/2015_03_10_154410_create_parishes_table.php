<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParishesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('parishes', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('town_id')->unsigned();
      $table->foreign('town_id')->references('id')->on('towns');
      $table->string('description');
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
    Schema::drop('parishes');
  }

}