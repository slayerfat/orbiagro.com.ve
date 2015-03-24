<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mamarrachismo\Transformer;

class Characteristic extends Model {

  protected $fillable = [
    'height',
    'width',
    'depth',
    'units',
    'weight'
  ];

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

}
