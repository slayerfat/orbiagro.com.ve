<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

  /**
   * Relaciones
   */
  public function users()
  {
    return $this->hasMany('App\User');
  }

}
