<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

class Category extends Model {

  protected $fillable = ['description', 'slug'];

  /**
   * Mutators
   */
  public function setDescriptionAttribute($value)
  {
    $this->attributes['description'] = ModelValidation::byLenght($value, 5);
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
  public function sub_categories()
  {
    return $this->hasMany('App\SubCategory');
  }

}
