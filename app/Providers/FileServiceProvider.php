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
    if (!$id = Auth::id()) return;

    File::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    File::updating(function($model) use($id){
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
