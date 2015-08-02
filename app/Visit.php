<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Visit extends Model {

  use InternalDBManagement;

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Belongs to
  // --------------------------------------------------------------------------
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  // --------------------------------------------------------------------------
  // Polymorphic
  // --------------------------------------------------------------------------
  public function visitable()
  {
    return $this->morphTo();
  }

}
