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
    $regex = '/(?P<cero>[0]?)(?P<code>[0-9]{3})(?P<trio>[\d]{3})(?P<gangbang>[\d]{4})/';
    $matches = [];
    if (preg_match($regex, $vale, $matches)) :
      return "({$matches['code']})-{$matches['trio']}-{$matches['gangbang']}";
    endif;
    return null;
  }

  /**
   * Mutators
   */
  public function setIdentityCardAttribute($value)
  {
    if (is_numeric($value)) :
      $this->attributes['identity_card'] = $value;
    else:
      $this->attributes['identity_card'] = null;
    endif;
  }

  public function setFirstNameAttribute($value)
  {
    if(trim($value) != '' && strlen($value) >= 5):
      var_dump($value);
      $this->attributes['first_name'] = $value;
    else:
      $this->attributes['first_name'] = null;
    endif;
  }

  public function setLastNameAttribute($value)
  {
    if(trim($value) != '' && strlen($value) >= 5):
      $this->attributes['last_name'] = $value;
    else:
      $this->attributes['last_name'] = null;
    endif;
  }

  public function setFirstSurnameAttribute($value)
  {
    if(trim($value) != '' && strlen($value) >= 5):
      $this->attributes['first_surname'] = $value;
    else:
      $this->attributes['first_surname'] = null;
    endif;
  }

  public function setLastSurnameAttribute($value)
  {
    if(trim($value) != '' && strlen($value) >= 5):
      $this->attributes['last_surname'] = $value;
    else:
      $this->attributes['last_surname'] = null;
    endif;
  }

  public function setPhoneAttribute($value)
  {
    $regex = '/(?P<cero>0)?(?P<numbers>\d{10})/';
    $matches = [];
    if (preg_match($regex, $vale, $matches)) :
      $this->attributes['phone'] = $matches['numbers'];
    else:
      $this->attributes['phone'] = null;
    endif;
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
