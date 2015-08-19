<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;
use App\Mamarrachismo\Traits\CanSearchRandomly;
use App\Mamarrachismo\Traits\HasShortTitle;

class SubCategory extends Model {

  use InternalDBManagement, CanSearchRandomly, HasShortTitle;

  protected $fillable = ['category_id', 'description', 'info'];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
  public function setDescriptionAttribute($value)
  {
    $this->attributes['description'] = ModelValidation::byLenght($value, 3);
    if($this->attributes['description'])
      $this->attributes['slug'] = str_slug($this->attributes['description']);
  }

  public function setInfoAttribute($value)
  {
    $this->attributes['info'] = ModelValidation::byLenght($value);
  }

  public function setSlugAttribute($value)
  {
    if (ModelValidation::byLenght($value, 3) !== null)
    {
      return $this->attributes['slug'] = str_slug($value);
    }

    return $this->attributes['slug'] = null;
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
  // Scopes
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Belongs To
  // --------------------------------------------------------------------------
  public function category()
  {
    return $this->belongsTo('App\Category');
  }

  // --------------------------------------------------------------------------
  // Has Many
  // --------------------------------------------------------------------------
  public function products()
  {
   return $this->hasMany('App\Product');
  }

  // --------------------------------------------------------------------------
  // Belongs To Many
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Polymorphic
  // --------------------------------------------------------------------------
  public function image()
  {
    return $this->morphOne('App\Image', 'imageable');
  }

  public function visits()
  {
    return $this->morphMany('App\Visit', 'visitable');
  }

}
