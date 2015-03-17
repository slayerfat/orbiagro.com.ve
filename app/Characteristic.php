<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model {

  protected $fillable = [
    'height',
    'width',
    'depth',
    'units',
    'weight',
    'created_by',
    'updated_by'
  ];

  /**
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
