<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

class Feature extends Model {

  protected $fillable = ['title', 'description'];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = ModelValidation::byLenght($value, 5);
  }

  public function setDescriptionAttribute($value)
  {
    $this->attributes['description'] = ModelValidation::byLenght($value, 5);
  }

  // --------------------------------------------------------------------------
  // Accessors
  // --------------------------------------------------------------------------
  public function getTitleAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

  // --------------------------------------------------------------------------
  // Polimorfica
  // --------------------------------------------------------------------------
  public function file()
  {
    return $this->morphOne('App\File', 'fileable');
  }

  public function image()
  {
    return $this->morphOne('App\Image', 'imageable');
  }

}
