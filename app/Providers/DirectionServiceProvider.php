<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Direction;

class DirectionServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    if (!$id = Auth::id()) return;

    Direction::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Direction::updating(function($model){
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
