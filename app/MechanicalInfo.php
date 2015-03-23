<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

class MechanicalInfo extends Model {

  protected $fillable = [
    'motor',
    'motor_serial',
    'model',
    'cylinders',
    'horsepower',
    'mileage',
    'traction',
    'lift',
  ];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setLiftAttribute($value)
  {
    $this->attributes['lift'] = ModelValidation::byNonNegative($value);
  }

  public function setTractionAttribute($value)
  {
    $this->attributes['traction'] = ModelValidation::byNonNegative($value);
  }

  public function setMileageAttribute($value)
  {
    $this->attributes['mileage'] = ModelValidation::byNonNegative($value);
  }

  public function setCylindersAttribute($value)
  {
    $this->attributes['cylinders'] = ModelValidation::byNonNegative($value);
  }

  public function setHorsePowerAttribute($value)
  {
    $this->attributes['horsepower'] = ModelValidation::byNonNegative($value);
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

  // --------------------------------------------------------------------------
  // Metodos Publicos
  // --------------------------------------------------------------------------
  public function mileage_km()
  {
    $mileage = ModelValidation::parseNumberToReadable($this->attributes['mileage']);
    if(isset($this->attributes['mileage'])) return "{$mileage} Km.";
    return null;
  }

  public function horsepower_hp()
  {
    $horsepower = ModelValidation::parseNumberToReadable($this->attributes['horsepower']);
    if(isset($this->attributes['horsepower'])) return "{$horsepower} HP.";
    return null;
  }
}
