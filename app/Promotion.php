<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model {

  protected $fillable = [
    'title',
    'slug',
    'percentage',
    'static',
    'begins',
    'ends',
  ];

  /**
   * Mutators
   */
  public function setTitleAttribute($value)
  {
    if($value != '' && strlen($value) >= 5):
      $this->attributes['title'] = $value;
      $this->attributes['slug']  = str_slug($value);
    else:
      $this->attributes['title'] = null;
    endif;
  }

  public function setSlugAttribute($value)
  {
    if($value != '' && strlen($value) >= 5):
      $this->attributes['slug']  = str_slug($value);
    else:
      $this->attributes['slug'] = null;
    endif;
  }

  public function setBeginsAttribute($value)
  {
    $date = \DateTime::createFromFormat('Y-m-d', $value);
    if($date):
      $this->attributes['begins'] = $value;
    else:
      $this->attributes['begins'] = null;
    endif;
  }

  public function setEndsAttribute($value)
  {
    $date = \DateTime::createFromFormat('Y-m-d', $value);
    if($date):
      $this->attributes['ends'] = $value;
    else:
      $this->attributes['ends'] = null;
    endif;
  }

  public function setStaticAttribute($value)
  {
    if($value > 0 && is_numeric($value)):
      $this->attributes['ends'] = $value;
    else:
      $this->attributes['ends'] = null;
    endif;
  }

  public function setPercentageAttribute($value)
  {
    if($value > 0 && is_numeric($value)):
      $this->attributes['ends'] = $value;
    else:
      $this->attributes['ends'] = null;
    endif;
  }

  /**
   * Accessors
   */
  public function getTitleAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  /**
   * Relaciones
   */
  public function products()
  {
    return $this->belongsToMany('App\Product');
  }

}
