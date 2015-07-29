<?php namespace App\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Characteristic;
use App\Feature;
use App\MechanicalInfo;
use App\Nutritional;

class ProductsDataModelsServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $id = Auth::id();

    Characteristic::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Characteristic::updating(function($model){
      $model->updated_by = $id;
    });

    Feature::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Feature::updating(function($model){
      $model->updated_by = $id;
    });

    MechanicalInfo::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    MechanicalInfo::updating(function($model){
      $model->updated_by = $id;
    });

    Nutritional::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Nutritional::updating(function($model){
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
