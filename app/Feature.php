<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model {

  protected $fillable = ['title', 'description', 'created_by', 'updated_by'];

  /**
   * Relaciones
   */
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   *
   * $a->person()->first()->direction()->save($b)
   * en donde $a es una instancia de User y
   * $b es una instancia de Direction
   */
  public function files()
  {
    return $this->morphMany('App\File', 'fileable');
  }

  public function images()
  {
    return $this->morphMany('App\Image', 'imageable');
  }

}
