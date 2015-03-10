<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model {

  //

  /**
   * Relaciones
   */
  public function people()
  {
    return $this->hasMany('App\Person');
  }
}
