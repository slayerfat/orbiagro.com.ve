<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Billing extends Model {

  use InternalDBManagement;

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------
  public function bank()
  {
    return $this->belongsTo('App\Bank');
  }

  public function cardType()
  {
    return $this->belongsTo('App\CardType');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

}
