<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;

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
    if (!$id = Auth::id()) return;

    Product::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Product::updating(function($model){
      $model->updated_by = $id;
    });

    Product::deleting(function($model){
      if ($this->forceDeleting = $model->isForceDeleting())
      {
        $this->images = $model->images;
        $this->id = $model->id;
      }
    });

    Product::deleted(function($model){
      if ($this->forceDeleting)
      {
        if ($this->images) $this->images->each(function($image){
          $image->delete();
        });

        if ($model->visits) $model->visits->each(function($visit){
          $visit->delete();
        });

        if ($model->direction) $model->direction->delete();

        return Storage::disk('public')->deleteDirectory("products/{$this->id}");
      }
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
