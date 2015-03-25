<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

class Maker extends Model {

  protected $fillable = ['name', 'domain', 'url'];


  /**
   * Mutators
   */
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = ModelValidation::byLenght($value, 3);
    $this->attributes['slug']  = str_slug($this->attributes['name']);
  }

  public function setSlugAttribute($value)
  {
    $slug = ModelValidation::byLenght($value, 3);
    if($slug):
      $this->attributes['slug'] = str_slug($slug);
    else:
      $this->attributes['slug'] = null;
    endif;
  }

  /**
   * Accessors
   */
  public function getNameAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  /**
   * Relaciones
   */
  public function products()
  {
    return $this->hasMany('App\Product');
  }

  /**
   * Belongs To Many
   */
  public function sub_categories()
  {
    return $this->belongsToMany('App\SubCategory');
  }

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   *
   * $a->images()->save($b)
   * en donde $a es una instancia de User y
   * $b es una instancia de Direction
   */
   public function images()
  {
    return $this->morphMany('App\Image', 'imageable');
  }

}
