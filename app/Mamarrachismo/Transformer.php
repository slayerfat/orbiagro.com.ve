<?php namespace App\Mamarrachismo;

class Transformer {

  /**
   * El numero representado en Centimetros,
   * o representado en Kilos.
   *
   * @var mixed
   */
  public $number;

  /**
   * la expresion regular para agarrar los numeros con coma
   * ej: 1.000,00
   * @var string
   */
  private $numberComaRegex = '/^-?(?P<numbers>\d+|\d{1,3}(?P<last>\.\d{3})+)(?P<decimal>\,(\s)?\d*)?$/';

  /**
   * la expresion regular para agarrar los numeros con coma
   * ej: 1000.00
   * @var string
   */
  private $numberDotRegex  = '/^-?(?P<numbers>\d+|\d{1,3}(?P<last>\.\d{3})+)(?P<decimal>\.(\s)?\d*)?$/';

  public function __construct($number = null)
  {
    $this->number = $number;
  }

  // --------------------------------------------------------------------------
  // Por Longitud
  // --------------------------------------------------------------------------
  public function fromMillimeter()
  {
    if (is_numeric($this->number)) :
      return $this->number /= 10;
    else:
      return null;
    endif;
  }

  public function toMillimeter()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 10;
    else:
      return null;
    endif;
  }

  public function fromMeter()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 100;
    else:
      return null;
    endif;
  }

  // --------------------------------------------------------------------------
  // Por Peso
  // --------------------------------------------------------------------------
  public function fromGram()
  {
    if (is_numeric($this->number)) :
      return $this->number /= 1000;
    else:
      return null;
    endif;
  }

  public function toGram()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 1000;
    else:
      return null;
    endif;
  }

  public function fromTon()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 1000;
    else:
      return null;
    endif;
  }

  public function toTon()
  {
    if (is_numeric($this->number)) :
      return $this->number /= 1000;
    else:
      return null;
    endif;
  }

  // --------------------------------------------------------------------------
  // Manipulacion de numeros
  // --------------------------------------------------------------------------

  /**
   * Chequea y devuelve el numero segun una cadena formateada.
   * ej: 987.654,32 -> 987654.32
   * @param mixed $value el numero a transformar.
   *
   * @return mixed.
   */
  public function parseReadableToNumber()
  {
    // se chequea el valor a comparar:
    if(preg_match($this->numberComaRegex, $this->number, $this->matches)) :
      // se quitan los puntos del string.
      $cleanNumbers = str_replace('.', '', $this->matches['numbers']);
      // si hay decimales en el string:
      if(isset($this->matches['decimal'])):
        // se cambian por comas los puntos.
        $decimal = str_replace(',', '.', $this->matches['decimal']);
        $number = "{$cleanNumbers}{$decimal}";
        // se castea a float.
        return (float)$number;
      endif;
      // si no hay decimales se castea a int.
      return (int)$cleanNumbers;
    endif;
    // si no es un numero propiamente formateado
    return null;
  }

  /**
   * Chequea y devuelve una cadena formateada segun el numero.
   * ej: 987654.32 -> 987.654,32
   * @param string $value el texto a transformar.
   *
   * @return mixed.
   */
  public function parseNumberToReadable()
  {
    // se chequea el valor a comparar:
    if(preg_match($this->numberDotRegex, $this->number, $this->matches)) :
      // se invierte la cadena para poder poner los puntos.
      $numbers = strrev($this->matches['numbers']);
      // la variable que contendra la cadena.
      $formatted = '';
      // variable de control para poner el punto en el lugar correcto.
      $j = 1;
      // se itera a travez de los numeros:
      for($i = 1; $i <= strlen($numbers); $i++) :
        if($j % 4 == 0) :
          $formatted .= '.'.$numbers[$i-1];
          $j = 2;
        else:
          $formatted .= $numbers[$i-1];
          $j++;
        endif;
      endfor;
      // se revierte a la forma original.
      $numbers = strrev($formatted);
      // si hay decimal se quitan los puntos y se devuelve.
      if(isset($this->matches['decimal'])):
        $decimal = str_replace('.', ',', $this->matches['decimal']);
        return "{$numbers}{$decimal}";
      endif;
      // si no hay decimales
      return "{$numbers}";
    endif;
    // si no es numero
    return null;
  }


  // --------------------------------------------------------------------------
  // Metodos Estaticos
  // --------------------------------------------------------------------------

  /**
   * @param  mixed  $value el numero a transformar/convertir.
   * @param  string $base  la unidad base de medida.
   * @param  string $to    la unidad final de medida.
   * @return mixed
   */
  public static function transform($value, $base, $to = null)
  {
    $transformer = new Transformer($value);

    if($to) return $transformer->transformTo($base, $to);

    return $transformer->fromSwitch($base);
  }

  /**
   * invoca parseNumberToReadable;
   *
   * @param mixed $value el numero a cambiar.
   */
  public static function toReadable($value)
  {
    $transformer = new Transformer($value);
    return $transformer->parseNumberToReadable();
  }

  // --------------------------------------------------------------------------
  // Metodos privados
  // --------------------------------------------------------------------------

  /**
   * refactored de self::transform.
   *
   * @param string $value la unidad de medida.
   */
  private function fromSwitch($value)
  {
    switch ($value) :
      // medidas de logitud
      case 'mm':
        return $this->fromMillimeter();
        break;

      case 'm':
        return $this->fromMeter();
        break;

      // medidas de peso
      case 'g':
        return $this->fromGram();
        break;

      case 'kg':
        return true;
        break;

      case 't':
        return $this->fromTon();
        break;

      default:
        throw new \Exception("Error, transformacion necesita unidad base", 1);
        break;
    endswitch;
  }

  /**
   * Metodo de apoyo para convertir numeros con unidades no base.
   * ej: toneladas a gramos.
   *
   * @param  string $base  la unidad base de medida.
   * @param  string $to    la unidad final de medida.
   * @return mixed
   */
  private function transformTo($base, $to)
  {
    $a = $this->fromSwitch($base);
    switch ($to) :
      case 'g':
        return $this->toGram();
        break;

      case 't':
        return $this->toTon();
        break;

      default:
        throw new \Exception("Error, transformacion necesita unidad de destino", 1);
        break;
    endswitch;
  }
}
