<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Product;
use Storage;

class ProductServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    Product::deleting(function($model){
      $this->images = $model->images;
      $this->id = $model->id;
    });

    Product::deleted(function($model){
      if ($this->images) $this->images->each(function($image){
        $image->delete();
      });
      return Storage::disk('public')->deleteDirectory("products/{$this->id}");
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
