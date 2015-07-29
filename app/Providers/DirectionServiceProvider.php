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
    Direction::creating(function($model){
      $model->created_by = Auth::id();
      $model->updated_by = Auth::id();
    });

    Direction::updating(function($model){
      $model->updated_by = Auth::id();
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
