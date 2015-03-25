<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model {

  /**
   * Relaciones
   */
  public function bank()
  {
    return $this->belongsTo('App\Bank');
  }

  public function card_type()
  {
    return $this->belongsTo('App\CardType');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

}
