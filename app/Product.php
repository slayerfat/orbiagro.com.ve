<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

  /**
   * Relaciones
   *
   * Belongs To
   */
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function category()
  {
    return $this->belongsTo('App\Category');
  }

  public function maker()
  {
    return $this->belongsTo('App\Maker');
  }

  /**
   * Has Many
   */
  public function purchases()
  {
    return $this->hasMany('App\Purchase');
  }

  public function features()
  {
    return $this->hasMany('App\Feature');
  }

  /**
   * Has One
   */
  public function characteristics()
  {
    return $this->hasOne('App\Characteristic');
  }

  /**
   * Belongs to many
   */
  public function promotions()
  {
    return $this->belongsToMany('App\Promotion');
  }

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   *
   * $a->product()->first()->direction()->save($b)
   * en donde $a es una instancia de User y
   * $b es una instancia de Direction
   */
  public function direction()
  {
    return $this->morphMany('App\Direction', 'directionable');
  }

  public function files()
  {
    return $this->morphMany('App\File', 'fileable');
  }

  public function images()
  {
    return $this->morphMany('App\Image', 'imageable');
  }

}
