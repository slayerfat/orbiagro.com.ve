<?php namespace App\Mamarrachismo;

use Validator;

class ModelValidation {

  /**
   * Regular Expresion para el numero de telefono con formato Venezolano.
   * @var string
   */
  private static $completePhoneRegex = '/(?P<cero>[0]?)(?P<code>[0-9]{3})(?P<trio>[\d]{3})(?P<gangbang>[\d]{4})/';
  private static $rawPhoneRegex      = '/(?P<cero>0)?(?P<numbers>\d{10})/';

  private static $numberComaRegex = '/^-?(?P<numbers>\d+|\d{1,3}(?P<last>\.\d{3})+)(?P<decimal>\,(\s)?\d*)?$/';
  private static $numberDotRegex  = '/^-?(?P<numbers>\d+|\d{1,3}(?P<last>\.\d{3})+)(?P<decimal>\.(\s)?\d*)?$/';

  /**
   * Chequea y devuelve el telefono acomodado.
   * ej: 02123334422 -> (212)-333-4422
   * @param string $value el telefono a chequear.
   *
   * @return string o null.
   */
  public static function parsePhone($value)
  {
    $matches = [];
    if (preg_match(self::$completePhoneRegex, $value, $matches)) :
      return "({$matches['code']})-{$matches['trio']}-{$matches['gangbang']}";
    endif;
    return null;
  }

  /**
   * Chequea y devuelve el numero segun una cadena formateada.
   * ej: 987.654,32 -> 987654.32
   * @param mixed $value el numero a transformar.
   *
   * @return mixed.
   */
  public static function parseReadableToNumber($value)
  {
    $matches = [];
    // se chequea el valor a comparar:
    if(preg_match(self::$numberComaRegex, $value, $matches)) :
      // se quitan los puntos del string.
      $cleanNumbers = str_replace('.', '', $matches['numbers']);
      // si hay decimales en el string:
      if(isset($matches['decimal'])):
        // se cambian por comas los puntos.
        $decimal = str_replace(',', '.', $matches['decimal']);
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
  public static function parseNumberToReadable($value)
  {
    $matches = [];
    // se chequea el valor a comparar:
    if(preg_match(self::$numberDotRegex, $value, $matches)) :
      // se invierte la cadena para poder poner los puntos.
      $numbers = strrev($matches['numbers']);
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
      if(isset($matches['decimal'])):
        $decimal = str_replace('.', ',', $matches['decimal']);
        return "{$numbers}{$decimal}";
      endif;
      // si no hay decimales
      return "{$numbers}";
    endif;
    // si no es numero
    return null;
  }

  /**
   * Chequea y devuelve el telefono en numeros.
   * ej: algo1232224455xzx -> 1232224455
   * @param string $value el telefono a chequear.
   *
   * @return string o null.
   */
  public static function parseRawPhone($value)
  {
    $matches = [];
    if (preg_match(self::$rawPhoneRegex, $value, $matches)) :
      return $matches['numbers'];
    endif;
    return null;
  }

  /**
   * Valida y regresa si es valido el valor.
   * @param string  $value  el valor a chequear.
   * @param integer $lenght el tamaño minimo.
   */
  public static function byLenght($value, $lenght = 5)
  {
    if(strlen(trim($value)) >= $lenght):
      return $value;
    endif;
    return null;
  }

  /**
   * Valida si es numero y regresa si es valido el valor.
   * @param mixed $value
   */
  public static function byNumeric($value)
  {
    if(is_numeric($value)):
      return $value;
    endif;
    return null;
  }

  /**
   * Valida si es numero y si es positivo, regresa si es valido el valor.
   * @param mixed $value
   */
  public static function byNonNegative($value)
  {
    $number = self::byNumeric($value);
    if ($number >= 0) {
      return $number;
    }
    return null;
  }

  public static function mime($value)
  {
    $validator = Validator::make(['mime' => $value], ['mime' => 'required|mimes:jpeg,gif,png']);
    if ($validator->fails()):
      return null;
    endif;
    return $value;
  }
}
