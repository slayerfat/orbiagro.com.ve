<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// use Auth;
use App\Image;
use File;

class ImageDeleteServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    // if (!$id = Auth::id()) return;
    //
    // Image::creating(function($model) use($id){
    //   $model->created_by = $id;
    //   $model->updated_by = $id;
    // });
    //
    // Image::updating(function($model) use($id){
    //   $model->updated_by = $id;
    // });

    Image::deleting(function($image){
      if(File::isFile($image->path))
        return File::delete($image->path);
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
