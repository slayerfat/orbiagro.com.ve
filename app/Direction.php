<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

class Direction extends Model {

  protected $fillable = ['parish_id', 'details'];

  /**
   * Mutators
   */
  public function setDetailsAttribute($value)
  {
    $this->attributes['details'] = ModelValidation::byLenght($value, 5);
  }

  /**
   * Accessors
   */
  public function getDetailsAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   */
  public function directionable()
  {
    return $this->morphTo();
  }

  // --------------------------------------------------------------------------
  // belongs to
  // --------------------------------------------------------------------------
  public function parish()
  {
    return $this->belongsTo('App\Parish');
  }

}
