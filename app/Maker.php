<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model {

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

}
