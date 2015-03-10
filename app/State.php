<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model {

  /**
   * Relaciones
   */
  public function towns(){
    return $this->hasMany('App\Towns');
  }

}
