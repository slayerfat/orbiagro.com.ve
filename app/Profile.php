<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

  /**
   * Mutators
   */
  public function setDescriptionAttribute($value)
  {
    if($value == '') :
      $this->attributes['description'] = null;
    else:
      $this->attributes['description'] = $value;
    endif;
  }

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
  public function users()
  {
    return $this->hasMany('App\User');
  }

}
