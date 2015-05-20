<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoType extends Model {

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // HasMany
  // --------------------------------------------------------------------------
  public function promotions()
  {
    return $this->HasMany('App\Promotion');
  }

}
