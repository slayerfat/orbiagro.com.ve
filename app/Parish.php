<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Parish extends Model {

  /**
   * Relaciones
   */
  public function town()
  {
    return $this->belongsTo('App\Town');
  }

  public function directions()
  {
    return $this->MorphMany('App\Direction');
  }

}
