<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MapDetail extends Model {

  protected $fillable = ['latitude', 'longitude', 'zoom'];

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  // belongs to
  // --------------------------------------------------------------------------
  public function product()
  {
    return $this->belongsTo('App\Direction');
  }
}
