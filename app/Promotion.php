<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Transformer;

use App\Mamarrachismo\Traits\InternalDBManagement;
use App\Mamarrachismo\Traits\CanSearchRandomly;

class Promotion extends Model {

  use InternalDBManagement, CanSearchRandomly;

  protected $fillable = [
    'title',
    'slug',
    'percentage',
    'static',
    'begins',
    'ends',
  ];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------
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
      $this->attributes['static'] = $value;
    else:
      $this->attributes['static'] = null;
    endif;
  }

  public function setPercentageAttribute($value)
  {
    if($value > 0 && is_numeric($value)):
      if ($this->isFloat($value)) :
        $this->attributes['percentage'] = $value * 100;
      else:
      $this->attributes['percentage'] = $value;
      endif;
    else:
      $this->attributes['percentage'] = null;
    endif;
  }


  // --------------------------------------------------------------------------
  // Accessors
  // --------------------------------------------------------------------------
  public function getTitleAttribute($value)
  {
    if($value) return ucfirst($value);
    return null;
  }

  // --------------------------------------------------------------------------
  // Scopes
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------

  // --------------------------------------------------------------------------
  // Belongs to Many
  // --------------------------------------------------------------------------
  public function products()
  {
    return $this->belongsToMany('App\Product');
  }

  // --------------------------------------------------------------------------
  // Belongs To
  // --------------------------------------------------------------------------
  public function type()
  {
    return $this->belongsTo('App\PromoType', 'promo_type_id', 'id');
  }

  // --------------------------------------------------------------------------
  // Polimorfica
  // --------------------------------------------------------------------------
  public function images()
  {
    return $this->morphMany('App\Image', 'imageable');
  }

  // --------------------------------------------------------------------------
  // Funciones publicas
  // --------------------------------------------------------------------------

  /**
   * Devuelve el descuento estatico concadenado con Bs.
   */
  public function readableStatic($otherNumber = null)
  {
    if ($otherNumber)
    {
      return Transformer::toReadable($otherNumber);
    }

    if (!isset($this->attributes['static']))
    {
      return null;
    }

    $price = Transformer::toReadable($this->attributes['static']);

    return "Bs. {$price}";
  }

  /**
   * Devuelve el descuento en porcentaje concadenado con %.
   */
  public function readablePercentage()
  {
    if(isset($this->attributes['percentage'])) return "{$this->attributes['percentage']}%";
    return null;
  }

  /**
   * Devuelve el descuento en numero ej: 100 => 1, 10 => 0.1.
   */
  public function decimalPercentage()
  {
    if(isset($this->attributes['percentage'])) return $this->attributes['percentage'] / 100;
    return null;
  }

  // --------------------------------------------------------------------------
  // Funciones protegidas
  // --------------------------------------------------------------------------

  /**
   * chequea si el valor es punto flotante o no.
   * @param mixed $value
   */
  protected function isFloat($value)
  {
    if(is_float($value)) return $value;
    return false;
  }
}
