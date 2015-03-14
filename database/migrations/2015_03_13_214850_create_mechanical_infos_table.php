<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMechanicalInfosTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mechanical_infos', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('products');
      $table->string('motor')->nullable();
      $table->tinyInteger('cylinders')->unsigned()->nullable();
      $table->integer('horsepower')->unsigned()->nullable();
      $table->integer('mileage')->unsigned()->nullable();
      $table->integer('traction')->unsigned()->nullable();
      $table->integer('lift')->unsigned()->nullable();
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
    Schema::drop('mechanical_infos');
  }

}
