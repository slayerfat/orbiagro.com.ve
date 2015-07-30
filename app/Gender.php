<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Gender extends Model {

  use InternalDBManagement;

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
