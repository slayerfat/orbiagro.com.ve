<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Category;
use Storage;

class CategoryServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    Category::deleting(function($model){
      if ($model->image) $model->image->delete();
      return Storage::disk('public')->deleteDirectory("category/{$model->id}");
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
