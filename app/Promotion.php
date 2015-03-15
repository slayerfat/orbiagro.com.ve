<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model {

  /**
   * Relaciones
   */
  public function products()
  {
    return $this->belongsToMany('App\Product');
  }

}
