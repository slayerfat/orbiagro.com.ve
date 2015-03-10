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

}
