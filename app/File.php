<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   */
  public function filable()
  {
    return $this->morphTo();
  }

}
