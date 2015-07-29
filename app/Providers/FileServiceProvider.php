<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\File;

class FileServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    $id = Auth::id();

    File::creating(function($model){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    File::updating(function($model){
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
