<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {

  protected $fillable = ['category_id', 'description', 'slug'];

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
