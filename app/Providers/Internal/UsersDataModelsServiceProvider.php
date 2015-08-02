<?php namespace App\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Gender;
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
    if (!$id = Auth::id()) return;

    $models = ['Gender', 'Nationality', 'Person'];

    foreach ($models as $m)
    {
      $m::creating(function($model) use($id){
        $model->created_by = $id;
        $model->updated_by = $id;
      });

      $m::updating(function($model) use($id){
        $model->updated_by = $id;
      });
    }
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
