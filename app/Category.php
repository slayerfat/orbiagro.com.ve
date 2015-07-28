<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

class Category extends Model {

  protected $fillable = ['description', 'slug', 'info'];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setDescriptionAttribute($value)
  {
    $this->attributes['description'] = ModelValidation::byLenght($value);
    if($this->attributes['description'])
      $this->attributes['slug'] = str_slug($this->attributes['description']);
  }

  public function setSlugAttribute($value)
  {
    if (ModelValidation::byLenght($value)) :
      $this->attributes['slug'] = str_slug($value);
    else:
      $this->attributes['slug'] = null;
    endif;
  }

  public function setInfoAttribute($value)
  {
    $this->attributes['info'] = ModelValidation::byLenght($value);
  }

  // --------------------------------------------------------------------------
  // Accessors
  // --------------------------------------------------------------------------
  public function getDescriptionAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  public function getInfoAttribute($value)
  {
    if($value) :
      if (substr($value, -1) !== '.')
      {
        $value .= '.';
      }
      return ucfirst($value);
    endif;

    return null;
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Has Many
  // --------------------------------------------------------------------------
  public function sub_categories()
  {
    return $this->hasMany('App\SubCategory');
  }

  // --------------------------------------------------------------------------
  // Polymorphic
  // --------------------------------------------------------------------------
  public function image()
  {
    return $this->morphOne('App\Image', 'imageable');
  }

  public function products()
  {
    return $this->hasManyThrough('App\product', 'App\SubCategory');
  }

}
