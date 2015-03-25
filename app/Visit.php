<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model {


  /**
   * Belongs To
   */
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   */
  public function visitable()
  {
    return $this->morphTo();
  }

}
