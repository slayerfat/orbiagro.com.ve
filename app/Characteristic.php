<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\Transformer;
use App\Mamarrachismo\ModelValidation;

use App\Mamarrachismo\Traits\InternalDBManagement;

class Characteristic extends Model {

  use InternalDBManagement;

  protected $fillable = [
    'height',
    'width',
    'depth',
    'units',
    'weight'
  ];

  // --------------------------------------------------------------------------
  // Mutators
  // --------------------------------------------------------------------------

  public function setWeightAttribute($value)
  {
    $this->attributes['weight'] = ModelValidation::byNonNegative($value);
  }

  public function setHeightAttribute($value)
  {
    $this->attributes['height'] = ModelValidation::byNonNegative($value);
  }

  public function setWidthAttribute($value)
  {
    $this->attributes['width'] = ModelValidation::byNonNegative($value);
  }

  public function setDepthAttribute($value)
  {
    $this->attributes['depth'] = ModelValidation::byNonNegative($value);
  }

  public function setUnitsAttribute($value)
  {
    $this->attributes['units'] = ModelValidation::byNonNegative($value);
  }

  // --------------------------------------------------------------------------
  // Accessors
  // --------------------------------------------------------------------------
  public function getDepthAttribute($value)
  {
    if($value) return $value;
    return null;
  }

  // --------------------------------------------------------------------------
  // Relaciones
  // --------------------------------------------------------------------------
  public function product()
  {
    return $this->belongsTo('App\Product');
  }

  // --------------------------------------------------------------------------
  // Public Methods
  // --------------------------------------------------------------------------

  /**
   * convierte algun valor numero a otra medida.
   *
   * @param  mixed  $int        el numero a convertir.
   * @param  string $base       la unidad de medida que esta asociada al numero.
   * @param  string $attribute  el atributo que se desea modificar.
   * @return mixed              el resultado.
   */
  public function convert($int, $base, $attribute = null)
  {
    if ($attribute) :
      return $this->attributes[$attribute] = Transformer::transform($int, $base);
    else:
      return Transformer::transform($int, $base);
    endif;
  }

  /**
   * Devuelve el peso en formato legible en Gramos.
   * @return mixed
   */
  public function weight_g()
  {
    $weight = Transformer::transform($this->attributes['weight'], 'kg', 'g');
    $weight = Transformer::toReadable($weight);
    if(isset($weight)) return "{$weight} g.";
    return null;
  }

  /**
   * Devuelve el peso en formato legible en Kg.
   * @return mixed
   */
  public function weight_kg()
  {
    $weight = Transformer::toReadable($this->attributes['weight']);
    if(isset($this->attributes['weight'])) return "{$weight} Kg.";
    return null;
  }

  /**
   * Devuelve el peso en formato legible en Toneladas.
   * @return mixed
   */
  public function weight_tons()
  {
    $weight = Transformer::transform($this->attributes['weight'], 'kg', 't');
    $weight = Transformer::toReadable($weight);
    if(isset($weight)) return "{$weight} T.";
    return null;
  }

  /**
   * Devuelve las unidades en formato legible en Unidades.
   * @return mixed
   */
  public function formatted_units()
  {
    $units = Transformer::toReadable($this->attributes['units']);
    if(isset($this->attributes['units'])) return "{$units} Unidades.";
    return null;
  }

  /**
   * Devuelve el ancho en formato legible en cm.
   * @return mixed
   */
  public function width_cm()
  {
    $width = Transformer::toReadable($this->attributes['width']);
    if(isset($this->attributes['width'])) return "{$width} cm.";
    return null;
  }

  /**
   * Devuelve el ancho en formato legible en mm.
   * @return mixed
   */
  public function width_mm()
  {
    $width = Transformer::transform($this->attributes['width'], 'cm', 'mm');
    $width = Transformer::toReadable($width);
    if(isset($this->attributes['width'])) return "{$width} mm.";
    return null;
  }

  /**
   * Devuelve el ancho en formato legible en cm.
   * @return mixed
   */
  public function height_cm()
  {
    $height = Transformer::toReadable($this->attributes['height']);
    if(isset($this->attributes['height'])) return "{$height} cm.";
    return null;
  }

  /**
   * Devuelve el ancho en formato legible en mm.
   * @return mixed
   */
  public function height_mm()
  {
    $height = Transformer::transform($this->attributes['height'], 'cm', 'mm');
    $height = Transformer::toReadable($height);
    if(isset($this->attributes['height'])) return "{$height} mm.";
    return null;
  }

  /**
   * Devuelve el ancho en formato legible en cm.
   * @return mixed
   */
  public function depth_cm()
  {
    $depth = Transformer::toReadable($this->attributes['depth']);
    if(isset($this->attributes['depth'])) return "{$depth} cm.";
    return null;
  }

  /**
   * Devuelve el ancho en formato legible en mm.
   * @return mixed
   */
  public function depth_mm()
  {
    $depth = Transformer::transform($this->attributes['depth'], 'cm', 'mm');
    $depth = Transformer::toReadable($depth);
    if(isset($this->attributes['depth'])) return "{$depth} mm.";
    return null;
  }

}
