<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model {

  /**
   * Relaciones
   */
  public function people()
  {
    return $this->hasMany('App\Person');
  }
}
