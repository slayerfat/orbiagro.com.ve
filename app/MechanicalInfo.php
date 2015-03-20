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

  /**
   * Mutators
   */
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

  /**
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
