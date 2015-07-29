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
    SubCategory::creating(function($model){
      $model->created_by = Auth::id();
      $model->updated_by = Auth::id();
    });

    SubCategory::updating(function($model){
      $model->updated_by = Auth::id();
    });

    SubCategory::deleting(function($model){
      $this->image = $model->image;
      $this->id = $model->id;
    });

    SubCategory::deleted(function($model){
      if ($this->image) $this->image->delete();
      return Storage::disk('public')->deleteDirectory("sub-category/{$this->id}");
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
