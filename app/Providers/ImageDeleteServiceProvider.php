<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    Image::deleting(function($image){
      dd(File::isFile($image->path));
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
