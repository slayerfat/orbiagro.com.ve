<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model {

  /**
   * Relaciones
   */
  public function productos()
  {
    return $this->belongsToMany('App\Product');
  }

}
