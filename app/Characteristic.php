<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\Transformer;

class Characteristic extends Model {

  protected $fillable = [
    'height',
    'width',
    'depth',
    'units',
    'weight'
  ];

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

  // --------------------------------------------------------------------------
  // Private Methods
  // --------------------------------------------------------------------------
  public function convert($int, $base)
  {
    return Transformer::transform($int, $base);
  }

}
