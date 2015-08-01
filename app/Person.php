<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Person extends Model {

  use InternalDBManagement;

  protected $fillable = [
    'first_name',
    'last_name',
    'first_surname',
    'last_surname',
    'identity_card',
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
    if (isset($this->attributes['first_name'])
      && isset($this->attributes['first_surname']))
    {
      return ucfirst($this->attributes['first_name']).
        ' '.
        ucfirst($this->attributes['first_surname']);
    }
    elseif (isset($this->attributes['first_name']))
    {
      return ucfirst($this->attributes['first_name']);
    }

    return null;
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
    $this->attributes['identity_card'] = ModelValidation::byNonNegative($value);
  }

  public function setFirstNameAttribute($value)
  {
    $this->attributes['first_name'] = ModelValidation::byLenght($value);
  }

  public function setLastNameAttribute($value)
  {
    $this->attributes['last_name'] = ModelValidation::byLenght($value);
  }

  public function setFirstSurnameAttribute($value)
  {
    $this->attributes['first_surname'] = ModelValidation::byLenght($value);
  }

  public function setLastSurnameAttribute($value)
  {
    $this->attributes['last_surname'] = ModelValidation::byLenght($value);
  }

  public function setPhoneAttribute($value)
  {
    $this->attributes['phone'] = ModelValidation::parseRawPhone($value);
  }

  public function setBirthDateAttribute($value)
  {
    $this->attributes['birth_date'] = ModelValidation::byLenght($value);
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
