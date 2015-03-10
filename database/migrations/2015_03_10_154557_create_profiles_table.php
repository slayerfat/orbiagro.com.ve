<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('profiles', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('description');
      $table->timestamps();
    });

    Schema::table('users', function(Blueprint $table)
    {
      $table->foreign('profile_id')->references('id')->on('profiles');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function(Blueprint $table)
    {
      $table->dropForeign('users_profile_id_foreign');
    });
    Schema::drop('profiles');
  }

}
