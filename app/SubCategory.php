<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {

  /**
   * Relaciones
   */
  public function category()
  {
    return $this->belongsTo('App\Category');
  }

}
