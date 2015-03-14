<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('billings', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->integer('bank_id')->unsigned()->nullable();
      $table->foreign('bank_id')->references('id')->on('banks');
      $table->integer('card_type_id')->unsigned()->nullable();
      $table->foreign('card_type_id')->references('id')->on('card_types');
      $table->string('card_number')->nullable();
      $table->string('bank_number')->nullable();
      $table->date('expiration')->nullable();
      $table->string('comments')->nullable();
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
    Schema::drop('billings');
  }

}
