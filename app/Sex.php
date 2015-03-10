<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sex extends Model {

  //

  /**
   * Relaciones
   */
  public function persons()
  {
    return $this->hasMany('App\User');
  }
}
