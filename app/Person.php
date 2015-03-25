<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

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
   * Accessors
   */
  public function getFirstNameAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  public function getLastNameAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  public function getFirstSurNameAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  public function getLastSurNameAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  public function formatted_names()
  {
    $names = ucfirst($this->attributes['first_name']).
      ' '.
      ucfirst($this->attributes['first_surname']);

    return $names;
  }

  public function getPhoneAttribute($value)
  {
    return ModelValidation::parsePhone($value);
  }

  /**
   * Mutators
   */
  public function setIdentityCardAttribute($value)
  {
    $this->attributes['identity_card'] = ModelValidation::byNumeric($value);
  }

  public function setFirstNameAttribute($value)
  {
    $this->attributes['first_name'] = ModelValidation::byLenght($value, 5);
  }

  public function setLastNameAttribute($value)
  {
    $this->attributes['last_name'] = ModelValidation::byLenght($value, 5);
  }

  public function setFirstSurnameAttribute($value)
  {
    $this->attributes['first_surname'] = ModelValidation::byLenght($value, 5);
  }

  public function setLastSurnameAttribute($value)
  {
    $this->attributes['last_surname'] = ModelValidation::byLenght($value, 5);
  }

  public function setPhoneAttribute($value)
  {
    $this->attributes['phone'] = ModelValidation::parseRawPhone($value);
  }

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
