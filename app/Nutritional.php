<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Nutritional extends Model {

  protected $fillable = ['due'];

  /**
   * Mutators
   */
  public function setDueAttribute($value)
  {
    $date = \DateTime::createFromFormat('Y-m-d', $value);
    if($date):
      $this->attributes['due'] = $value;
    else:
      $this->attributes['due'] = null;
    endif;
  }

  /**
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

}
