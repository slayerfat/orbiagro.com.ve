<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('images', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('imageable_id')->unsigned();
      $table->string('imageable_type');
      $table->string('path');
      $table->string('alt');
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
    Schema::drop('images');
  }

}
