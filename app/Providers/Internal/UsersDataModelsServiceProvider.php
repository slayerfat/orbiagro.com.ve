<?php namespace App\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Profile;
use App\Nationality;
use App\Person;

class UsersDataModelsServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $id = Auth::id();

    Profile::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Profile::updating(function($model){
      $model->updated_by = $id;
    });

    Nationality::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Nationality::updating(function($model){
      $model->updated_by = $id;
    });

    Person::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Person::updating(function($model){
      $model->updated_by = $id;
    });
  }

  /**
   * Register the application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

}
