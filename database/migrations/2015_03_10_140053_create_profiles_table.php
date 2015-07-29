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
      $table->string('description')->unique();
      $table->timestamps();
    });

    $this->seedProfiles();

    Schema::table('users', function(Blueprint $table)
    {
      $table->foreign('profile_id')->references('id')->on('profiles');
    });

    $this->seedUser();
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

  /**
   * se decidio hacer esto asi por el hecho de que
   * la gran mayoria de las tablas tienen created by
   * y updated by lo que implica que se necesita un usuario
   * antes de poder crear el esquema de datos.
   *
   * @method seedProfiles
   * @return void
   */
  private function seedProfiles()
  {
    $types = [
      'Administrador',
      'Usuario',
      'Desactivado'
    ];

    foreach($types as $profile):
      $model = new App\Profile;
      $model->description = $profile;
      $model->save();
    endforeach;
  }

  /**
   * crea al primer usuario del sistema.
   *
   * @method seedUser
   * @return void
   */
  private function seedUser()
  {
    $admin = App\Profile::where('description', 'Administrador')->firstOrFail();

    $model             = new App\User;
    $model->profile_id = $admin->id;
    $model->created_at = Carbon\Carbon::now();
    $model->updated_at = Carbon\Carbon::now();

    if (app()->environment() == 'testing')
    {
      $model->name       = 'tester';
      $model->email      = 'tester@tester.com';
      $model->password   = Hash::make('tester');
    }
    else
    {
      $model->name       = env('APP_USER');
      $model->email      = env('APP_USER_EMAIL');
      $model->password   = env('APP_USER_PASSWORD');
    }

    $model->save();
  }

}
