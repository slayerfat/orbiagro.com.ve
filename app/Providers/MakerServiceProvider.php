<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Maker;
use Storage;

class MakerServiceProvider extends ServiceProvider {

  protected $image, $id;

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    Maker::creating(function($model){
      $model->created_by = Auth::id();
      $model->updated_by = Auth::id();
    });

    Maker::updating(function($model){
      $model->updated_by = Auth::id();
    });

    Maker::deleting(function($model){
      $this->image = $model->image;
      $this->id = $model->id;
    });

    Maker::deleted(function($model){
      if ($this->image) $this->image->delete();
      return Storage::disk('public')->deleteDirectory("makers/{$this->id}");
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
