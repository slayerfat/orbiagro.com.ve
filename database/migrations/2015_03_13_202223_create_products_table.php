<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->integer('category_id')->unsigned();
      $table->foreign('category_id')->references('id')->on('categories');
      $table->integer('maker_id')->unsigned();
      $table->foreign('maker_id')->references('id')->on('makers');
      $table->string('title');
      $table->text('description');
      $table->double('price', 12, 2)->unsigned();
      $table->integer('quantity')->unsigned();
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
    Schema::drop('products');
  }

}
