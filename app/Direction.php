<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model {

  protected $fillable = ['parish_id', 'details'];

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   */
  public function directionable()
  {
    return $this->morphTo();
  }

}
