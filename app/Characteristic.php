<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model {

  /**
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
