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
    if (!$id = Auth::id()) return;

    Characteristic::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Characteristic::updating(function($model) use($id){
      $model->updated_by = $id;
    });

    Feature::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Feature::updating(function($model) use($id){
      $model->updated_by = $id;
    });

    MechanicalInfo::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    MechanicalInfo::updating(function($model) use($id){
      $model->updated_by = $id;
    });

    Nutritional::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Nutritional::updating(function($model) use($id){
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
