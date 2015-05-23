<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapDetailsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('map_details', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('direction_id')->unsigned();
      $table->foreign('direction_id')
            ->references('id')
            ->on('directions')
            ->onDelete('cascade');
      $table->double('latitude', 17, 15);
      $table->double('longitude', 18, 15);
      $table->tinyInteger('zoom')->unisgned();
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
    Schema::drop('map_details');
  }

}
