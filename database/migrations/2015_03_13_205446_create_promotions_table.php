<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('promotions', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('title');
      $table->string('slug');
      $table->integer('percentage')->unsigned()->nullable();
      $table->integer('static')->unsigned()->nullable();
      $table->date('begins');
      $table->date('ends');
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
    Schema::drop('promotions');
  }
}
