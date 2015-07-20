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
      $this->image = $model->image;
      $this->id = $model->id;
    });

    Category::deleted(function($model){
      if ($this->image) $this->image->delete();
      return Storage::disk('public')->deleteDirectory("category/{$this->id}");
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
