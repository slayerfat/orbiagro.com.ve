<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
