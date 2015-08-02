<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Nutritional extends Model {

  use InternalDBManagement;

  protected $fillable = ['due'];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setDueAttribute($value)
  {
    $date = \DateTime::createFromFormat('Y-m-d', $value);
    if($date):
      $this->attributes['due'] = $value;
    else:
      $this->attributes['due'] = null;
    endif;
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Belongs To
  // --------------------------------------------------------------------------
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
