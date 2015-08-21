<?php namespace App\Mamarrachismo;

use Validator;
use App\User;

/**
* @todo mejorar los metodos estaticos de esta clase
*/
class ModelValidation
{

    /**
    * @var string
    */
    public $userId;

    /**
    * @var \App\User
    */
    public $user;

    public function __construct($userId = null, User $user = null)
    {
        $this->userId = $userId;

        $this->user   = $user;
    }

    /**
    * Regular Expresion para el numero de telefono con formato Venezolano.
    * 0123456478
    *
    * @var string
    */
    private static $completePhoneRegex = '/(?P<cero>[0]?)(?P<code>[0-9]{3})(?P<trio>[\d]{3})(?P<gangbang>[\d]{4})/';

    /**
     * Regular Expresion para el numero de telefono con formato no Venezolano.
     * 01234564789
     *
     * @var string
     */
    private static $rawPhoneRegex      = '/(?P<cero>0)?(?P<numbers>\d{10})/';

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

        if (preg_match(self::$completePhoneRegex, $value, $matches)) {
            return "({$matches['code']})-{$matches['trio']}-{$matches['gangbang']}";
        }

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

        if (preg_match(self::$rawPhoneRegex, $value, $matches)) {
            return $matches['numbers'];
        }

        return null;
    }

    /**
    * Valida y regresa si es valido el valor.
    * @param string  $value  el valor a chequear.
    * @param integer $lenght el tamaño minimo.
    */
    public static function byLenght($value, $lenght = 5)
    {
        if (strlen(trim($value)) >= $lenght) {
            return $value;
        }

        return null;
    }

    /**
    * Valida si es numero y regresa si es valido el valor.
    * @param mixed $value
    */
    public static function byNumeric($value)
    {
        if (is_numeric($value)) {
            return $value;
        }

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
}
