<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model {

  protected $fillable = [
    'first_name',
    'last_name',
    'first_surname',
    'last_surname',
    'phone',
    'birth_date'
  ];

  /**
   * Relaciones
   */

  public function gender()
  {
    return $this->belongsTo('App\Gender');
  }

  public function nationality()
  {
    return $this->belongsTo('App\Nationality');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  /**
   * Relacion polimorfica
   * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
   *
   * $a->person()->first()->direction()->save($b)
   * en donde $a es una instancia de User y
   * $b es una instancia de Direction
   */
  public function direction()
  {
    return $this->morphMany('App\Direction', 'directionable');
  }

}
