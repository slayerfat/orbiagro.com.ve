<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model {

  /**
   * Belongs To
   */
  public function user()
  {
    return $this->belongsTo('App\User');
  }

}
