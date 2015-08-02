<?php namespace App\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Bank;
use App\CardType;

class BankAndCardTypeServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
    if (!$id = Auth::id()) return;

    Bank::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    Bank::updating(function($model) use($id){
      $model->updated_by = $id;
    });

    CardType::creating(function($model) use($id){
      $model->created_by = $id;
      $model->updated_by = $id;
    });

    CardType::updating(function($model) use($id){
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
