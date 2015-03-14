<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MechanicalInfo extends Model {

  /**
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
