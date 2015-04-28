<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

class MapDetail extends Model {

  protected $fillable = ['latitude', 'longitude', 'zoom'];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setLatitudeAttribute($value)
  {
    $this->attributes['latitude'] = ModelValidation::byNumeric($value);

    if(abs($this->attributes['latitude']) >= 91) $this->attributes['latitude'] = null;
  }

  public function setLongitudeAttribute($value)
  {
    $this->attributes['longitude'] = ModelValidation::byNumeric($value);

    if(abs($this->attributes['longitude']) >= 181) $this->attributes['longitude'] = null;
  }

  public function setZoomAttribute($value)
  {
    $this->attributes['zoom'] = ModelValidation::byNonNegative($value);

    if(abs($this->attributes['zoom']) > 24) $this->attributes['zoom'] = null;
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------
  // --------------------------------------------------------------------------
  // belongs to
  // --------------------------------------------------------------------------
  public function direction()
  {
    return $this->belongsTo('App\Direction');
  }
}
