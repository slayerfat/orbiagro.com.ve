<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

  protected $fillable = ['description', 'slug'];

  /**
   * Mutators
   */
  public function setDescriptionAttribute($value)
  {
    if(trim($value) == '') :
      $this->attributes['description'] = null;
    else:
      $this->attributes['description'] = $value;
    endif;
  }

  /**
   * Relaciones
   */
  public function subcategories()
  {
    return $this->hasMany('App\SubCategory');
  }

}
