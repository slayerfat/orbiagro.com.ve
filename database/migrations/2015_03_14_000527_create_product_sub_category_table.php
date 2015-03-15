<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSubCategoryTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_sub_category', function(Blueprint $table)
    {
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('products');
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
    Schema::drop('product_sub_category');
  }

}
