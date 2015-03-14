<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('makers', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('name');
      $table->string('web_page');
      $table->string('logo_path');
      $table->string('logo_alt');
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
    Schema::drop('makers');
  }

}
