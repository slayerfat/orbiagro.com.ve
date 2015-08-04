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

  /**
   * atributo utilizado para guardar el resultado
   * de la expresion regular cuando se parsea.
   *
   * @var array
   */
  private $matches;

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
    endif;
    return null;
  }

  public function toMillimeter()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 10;
    endif;
    return null;
  }

  public function fromMeter()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 100;
    endif;
    return null;
  }

  // --------------------------------------------------------------------------
  // Por Peso
  // --------------------------------------------------------------------------
  public function fromGram()
  {
    if (is_numeric($this->number)) :
      return $this->number /= 1000;
    endif;
    return null;
  }

  public function toGram()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 1000;
    endif;
    return null;
  }

  public function fromTon()
  {
    if (is_numeric($this->number)) :
      return $this->number *= 1000;
    endif;
    return null;
  }

  public function toTon()
  {
    if (is_numeric($this->number)) :
      return $this->number /= 1000;
    endif;
    return null;
  }

  // --------------------------------------------------------------------------
  // Manipulacion de numeros
  // --------------------------------------------------------------------------

  /**
   * Chequea y devuelve el numero segun una cadena formateada.
   * ej: 987.654,32 -> 987654.32
   *
   * @return mixed
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
   *
   * @return mixed
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
      $control = 1;
      // se itera a travez de los numeros:
      for($i = 1; $i <= strlen($numbers); $i++) :
        if($control % 4 == 0) :
          $formatted .= '.'.$numbers[$i-1];
          $control = 2;
        elseif($control % 4 != 0) :
          $formatted .= $numbers[$i-1];
          $control++;
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

  /**
   * Metodo de apoyo para convertir numeros con unidades no base.
   * ej: toneladas a gramos.
   *
   * @param  string $transformTo  hacia donde se va a cambiar
   * @return mixed
   */
  public function transformTo($transformTo)
  {
    switch ($transformTo) :
      case 'mm':
        return $this->toMillimeter();

      // unidad de peso
      case 'g':
        return $this->toGram();

      case 't':
        return $this->toTon();

      default:
        throw new \Exception("Error, transformacion necesita unidad de destino", 1);

    endswitch;
  }

  /**
   * refactored de self::transform.
   *
   * @param string $value la unidad de medida.
   */
  public function make($value)
  {
    switch ($value) :
      // medidas de logitud
      case 'mm':
        return $this->fromMillimeter();

      case 'cm':
        return true;

      case 'm':
        return $this->fromMeter();

      // medidas de peso
      case 'g':
        return $this->fromGram();

      case 'kg':
        return true;

      case 't':
        return $this->fromTon();

      default:
        throw new \Exception("Error, transformacion necesita unidad base", 1);

    endswitch;
  }


  // --------------------------------------------------------------------------
  // Manipulacion de arrays
  // --------------------------------------------------------------------------
  /**
   * http://php.net/manual/en/function.preg-grep.php#111673
   *
   * regresa un array con los elementos que sean encontrados segun el patron
   * nota: la busqueda se hace por el key del array
   * ej: array['pito'] -> guacharaca
   * ej: array['foo'] -> bar
   *
   * @param $pattern string la expresion regular.
   * @param $input array el array a iterar.
   *
   * @return array
   */
  public function getArrayByPattern($pattern, $input, $flags = 0)
  {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
  }


  // --------------------------------------------------------------------------
  // Metodos Estaticos
  // --------------------------------------------------------------------------

  /**
   * @param  mixed  $value     el numero a transformar/convertir.
   * @param  string $base      la unidad base de medida.
   * @param  string $traformTo la unidad final de medida.
   * @return mixed
   */
  public static function transform($value, $base, $traformTo = null)
  {
    $transformer = new Transformer($value);

    if($traformTo) return $transformer->transformTo($traformTo);

    return $transformer->make($base);
  }

  /**
   * http://php.net/manual/en/function.preg-grep.php#111673
   *
   * invoca getArrayByPattern
   *
   * regresa un array con los elementos que sean encontrados segun el patron
   * nota: la busqueda se hace por el key del array
   * ej: array['pito'] -> guacharaca
   * ej: array['foo'] -> bar
   *
   * @param $pattern string la expresion regular.
   * @param $input array el array a iterar.
   *
   * @return array
   */
  public static function getArrayByKeyValue($pattern, $input, $flags = 0)
  {
    $transformer = new Transformer();
    return $transformer->getArrayByPattern($pattern, $input, $flags);
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

  /**
   * invoca parseNumberToReadable;
   *
   * @param mixed $value el numero a cambiar.
   */
  public static function toNumber($value)
  {
    $transformer = new Transformer($value);
    return $transformer->parseReadableToNumber();
  }

  // --------------------------------------------------------------------------
  // Metodos privados
  // --------------------------------------------------------------------------


}
