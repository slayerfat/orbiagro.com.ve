<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model {

  /**
   * Relaciones
   */
  public function products()
  {
    return $this->hasMany('App\Product');
  }

}
