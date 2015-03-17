<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model {

  /**
   * Relaciones
   */
  public function state()
  {
    return $this->belongsTo('App\State');
  }

  public function parishes()
  {
    return $this->hasMany('App\Parish');
  }
}
