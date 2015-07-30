<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Bank extends Model {

  use InternalDBManagement;

  /**
   * Relaciones
   */
  public function billings()
  {
    return $this->hasMany('App\Billing');
  }
}
