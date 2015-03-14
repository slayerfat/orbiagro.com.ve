<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   */
  public function imageable()
  {
    return $this->morphTo();
  }

}
