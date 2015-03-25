<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model {

  /**
   * Accessors
   */
  public function getDescriptionAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  /**
   * Relaciones
   */
  public function people()
  {
    return $this->hasMany('App\Person');
  }
}
