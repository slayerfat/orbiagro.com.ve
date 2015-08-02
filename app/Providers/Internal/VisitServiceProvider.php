<?php namespace App\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Visit;

class VisitServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    if (!$id = Auth::id()) return;

    Visit::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Visit::updating(function($model) use($id){
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
