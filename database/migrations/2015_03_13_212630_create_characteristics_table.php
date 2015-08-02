<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacteristicsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('characteristics', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
      $table->integer('height')->unsigned()->nullable();
      $table->integer('width')->unsigned()->nullable();
      $table->integer('depth')->unsigned()->nullable();
      $table->integer('weight')->unsigned()->nullable();
      $table->integer('units')->unsigned()->nullable();
      $table->timestamps();
      $table->integer('created_by')->unsigned();
      $table->foreign('created_by')->references('id')->on('users');
      $table->integer('updated_by')->unsigned();
      $table->foreign('updated_by')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('characteristics');
  }

}
