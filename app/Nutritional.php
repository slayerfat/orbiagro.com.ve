<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Nutritional extends Model {

  protected $fillable = ['due'];

  /**
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
