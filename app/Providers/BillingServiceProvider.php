<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Billing;

class BillingServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    if (!$id = Auth::id()) return;

    Billing::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Billing::updating(function($model) use($id){
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
