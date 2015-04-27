<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Parish extends Model {

  // --------------------------------------------------------------------------
  // Relaciones
  //
  // belongs to
  // --------------------------------------------------------------------------
  public function town()
  {
    return $this->belongsTo('App\Town');
  }

  // --------------------------------------------------------------------------
  // has many
  // --------------------------------------------------------------------------
  public function directions()
  {
    return $this->hasMany('App\Direction');
  }

}
