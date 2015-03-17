<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CardType extends Model {

  /**
   * Relaciones
   */
  public function billings()
  {
    return $this->hasMany('App\Billing');
  }

}
