<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

  /**
   * Relaciones
   */
  public function products()
  {
    return $this->hasMany('App\Product');
  }

  public function subcategories()
  {
    return $this->hasMany('App\SubCategory');
  }

}
