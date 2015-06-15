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
      $table->string('name')->unique();
      $table->string('slug');
      $table->string('domain')->nullable();
      $table->string('url')->nullable();
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
