<?php namespace App\Mamarrachismo;

class ModelValidation {

  /**
   * Los valores a atrapar para devolver
   * @var array
   */
  protected $matches = [];

  /**
   * Regular Expresion para el numero de telefono con formato Venezolano.
   * @var string
   */
  private static $completePhoneRegex = '/(?P<cero>[0]?)(?P<code>[0-9]{3})(?P<trio>[\d]{3})(?P<gangbang>[\d]{4})/';
  private static $rawPhoneRegex = '/(?P<cero>0)?(?P<numbers>\d{10})/';

  /**
   * Chequea y devuelve el telefono acomodado.
   * ej: 02123334422 -> (212)-333-4422
   * @param string $value el telefono a chequear.
   *
   * @return string o null.
   */
  public static function parsePhone($value)
  {
    if (preg_match($completePhoneRegex, $value, $this->matches)) :
      return "({$this->matches['code']})-{$this->matches['trio']}-{$this->matches['gangbang']}";
    endif;
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
    if (preg_match($completeRegex, $value, $this->matches)) :
      return $matches['numbers'];
    endif;
    return null;
  }

  /**
   * Valida y regresa si es valido el valor.
   * @param string  $value  el valor a chequear.
   * @param integer $lenght el tamaño minimo.
   */
  public static function validateByLenght($value, $lenght = 5)
  {
    if(strlen(trim($value)) >= $lenght):
      return $value;
    endif;
    return null;
  }

  /**
   * Valida si es numero y regresa si es valido el valor.
   * @param integer $value
   */
  public static function validateByNumeric($value)
  {
    if(is_numeric($value)):
      return $value;
    endif;
    return null;
  }
}
