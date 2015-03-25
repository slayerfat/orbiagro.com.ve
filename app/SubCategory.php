<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {

  protected $fillable = ['category_id', 'description', 'slug'];

  /**
   * Mutators
   */
  public function setDescriptionAttribute($value)
  {
    if($value == '') :
      $this->attributes['description'] = null;
    else:
      $this->attributes['description'] = $value;
    endif;
  }

  /**
   * Accessors
   */
  public function getDescriptionAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  /**
   * Relaciones
   */
  public function category()
  {
    return $this->belongsTo('App\Category');
  }

  /**
   * Has Many
   */


  /**
   * Belongs To Many
   */
  public function makers()
  {
    return $this->belongsToMany('App\Maker');
  }

  public function products()
  {
   return $this->belongsToMany('App\Product');
  }

}
