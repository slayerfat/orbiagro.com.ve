<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('providers', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('name')->unique();
      $table->string('slug');
      $table->string('url')->nullable();
      $table->string('contact_name')->nullable();
      $table->string('contact_title')->nullable();
      $table->string('contact_email')->nullable();
      $table->string('contact_phone_1')->nullable();
      $table->string('contact_phone_2')->nullable();
      $table->string('contact_phone_3')->nullable();
      $table->string('contact_phone_4')->nullable();
      $table->string('email')->nullable();
      $table->string('phone_1')->nullable();
      $table->string('phone_2')->nullable();
      $table->string('phone_3')->nullable();
      $table->string('phone_4')->nullable();
      $table->string('trust', 3)->nullable();
      $table->integer('created_by')->unsigned();
      $table->foreign('created_by')->references('id')->on('users');
      $table->integer('updated_by')->unsigned();
      $table->foreign('updated_by')->references('id')->on('users');
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
    Schema::drop('providers');
  }

}
