<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

  protected $fillable = ['description', 'slug'];

  /**
   * Relaciones
   */
  public function subcategories()
  {
    return $this->hasMany('App\SubCategory');
  }

}
