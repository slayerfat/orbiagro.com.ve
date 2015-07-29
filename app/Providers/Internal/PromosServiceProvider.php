<?php namespace App\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Promotion;
use App\PromoType;

class PromosServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $id = Auth::id();

    Promotion::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Promotion::updating(function($model){
      $model->updated_by = $id;
    });

    PromoType::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    PromoType::updating(function($model){
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
