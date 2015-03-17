<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakerSubCategory extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('maker_sub_category', function(Blueprint $table)
    {
      $table->integer('maker_id')->unsigned();
      $table->foreign('maker_id')->references('id')->on('makers');
      $table->integer('sub_category_id')->unsigned();
      $table->foreign('sub_category_id')->references('id')->on('sub_categories');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('maker_sub_category');
  }

}
