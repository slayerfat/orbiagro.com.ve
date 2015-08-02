<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Feature extends Model {

  use InternalDBManagement;

  protected $fillable = ['title', 'description'];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setTitleAttribute($value)
  {
    $this->attributes['title'] = ModelValidation::byLenght($value);
  }

  public function setDescriptionAttribute($value)
  {
    $this->attributes['description'] = ModelValidation::byLenght($value);
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
