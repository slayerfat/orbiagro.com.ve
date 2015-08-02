<?php namespace App\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\State;
use App\Town;
use App\Parish;

class DirDataModelsServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    if (!$id = Auth::id()) return;

    State::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    State::updating(function($model) use($id){
      $model->updated_by = $id;
    });

    Town::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Town::updating(function($model) use($id){
      $model->updated_by = $id;
    });

    Parish::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Parish::updating(function($model) use($id){
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
