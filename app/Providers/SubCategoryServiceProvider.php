<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\SubCategory;
use Storage;

class SubCategoryServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    SubCategory::deleting(function($model){
      if ($model->image) $model->image->delete();
      return Storage::disk('public')->deleteDirectory("sub-category/{$model->id}");
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
