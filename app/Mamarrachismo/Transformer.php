<?php namespace App\Mamarrachismo;

class Transformer
{

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

    /**
     * @param int $number
     *
     * @return void
     */
    public function __construct($number = null)
    {
        $this->number = $number;
    }

    // --------------------------------------------------------------------------
    // Por Longitud
    // --------------------------------------------------------------------------

    /**
     * @return number
     */
    public function fromMillimeter()
    {
        return $this->number /= 10;
    }

    /**
     * @return number
     */
    public function toMillimeter()
    {
        return $this->number *= 10;
    }

    /**
     * @return number
     */
    public function fromMeter()
    {
        return $this->number *= 100;
    }

    // --------------------------------------------------------------------------
    // Por Peso
    // --------------------------------------------------------------------------
    /**
     * @return number
     */
    public function fromGram()
    {
        return $this->number /= 1000;
    }

    /**
     * @return number
     */
    public function toGram()
    {
        return $this->number *= 1000;
    }

    /**
     * @return number
     */
    public function fromTon()
    {
        return $this->number *= 1000;
    }

    /**
     * @return number
     */
    public function toTon()
    {
        return $this->number /= 1000;
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
        if (!$this->doRegex($this->numberComaRegex, $this->number)) {
            return null;
        }

        // se quitan los puntos del string.
        $numbers = str_replace('.', '', $this->matches['numbers']);

        $numbers = $numbers + 0;

        if ($this->isMatchesANegativeNumber()) {
            $numbers = $numbers * -1;
        }

        return $this->attachMatchesDecimal($numbers);
    }

    /**
     * Chequea y devuelve una cadena formateada segun el numero.
     * ej: 987654.32 -> 987.654,32
     *
     * @return mixed
     */
    public function parseNumberToReadable()
    {
        if (!$this->doRegex($this->numberDotRegex, $this->number)) {
            return null;
        }

        // se invierte la cadena para poder poner los puntos.
        $numbers = strrev($this->matches['numbers']);

        // la variable que contendra la cadena.
        $formatted = '';

        // variable de control para poner el punto en el lugar correcto.
        $control = 1;

        // se itera a travez de los numeros:
        for ($i = 1; $i <= strlen($numbers); $i++) {
            if ($control % 4 == 0) {
                $formatted .= '.'.$numbers[$i-1];
                $control = 2;
            } elseif ($control % 4 != 0) {
                $formatted .= $numbers[$i-1];
                $control++;
            }
        }

        // se revierte a la forma original.
        $numbers = strrev($formatted);

        if ($this->isMatchesANegativeNumber()) {
            $numbers = '-'.$numbers;
        }

        return $this->attachMatchesDecimal($numbers);
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
        switch ($transformTo) {
            case 'mm':
                return $this->toMillimeter();

            // unidad de peso
            case 'g':
                return $this->toGram();

            case 't':
                return $this->toTon();

            default:
                throw new \Exception("Error, transformacion necesita unidad de destino", 1);

        }
    }

    /**
     * refactored de self::transform.
     *
     * @param string $value la unidad de medida.
     *
     * @return number
     */
    public function make($value)
    {
        switch ($value) {
            // medidas de logitud
            case 'mm':
                return $this->fromMillimeter();

            case 'cm':
                return $this->number;

            case 'm':
                return $this->fromMeter();

            // medidas de peso
            case 'g':
                return $this->fromGram();

            case 'kg':
                return $this->number;

            case 't':
                return $this->fromTon();

            default:
                throw new \Exception("Error, transformacion necesita unidad base", 1);
        }
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

        if ($traformTo !== null) {
            return $transformer->transformTo($traformTo);
        }

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
     *
     * @return mixed
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
     *
     * @return mixed
     */
    public static function toNumber($value)
    {
        $transformer = new Transformer($value);

        return $transformer->parseReadableToNumber();
    }

    // --------------------------------------------------------------------------
    // Metodos privados
    // --------------------------------------------------------------------------

    /**
     * cambia de 923.1 ---> 923,1 y viceversa.
     *
     * @param  mixed $number el numero a manipular
     * @return mixed
     */
    private function attachMatchesDecimal($number)
    {
        // si no hay decimales se castea a int.
        if (!isset($this->matches['decimal'])) {
            return $number;
        }

        if (is_string($number)) {
            $decimal = str_replace('.', ',', $this->matches['decimal']);
            return "{$number}{$decimal}";
        } elseif (!is_string($number)) {
            $decimal = str_replace(',', '.', $this->matches['decimal']);
            $number = "{$number}{$decimal}";
            return (float)$number;
        }
    }

    /**
     * @param  string $regex  la expresion regular a comparar
     * @param  int $number el numero a comparar
     *
     * @return mixed
     */
    private function doRegex($regex, $number = null)
    {
        if ($number !== null) {
            $this->number = $number;
        }

        // se chequea el valor a comparar:
        if (!preg_match($regex, $this->number, $this->matches)) {
            // si no hay resultados
            return null;
        }

        return $this->matches;
    }

    /**
     * @return boolean
     */
    private function isMatchesANegativeNumber()
    {
        // dentro del primer array, el primer caracter
        if ($this->matches[0][0] == '-') {
            return true;
        }

        return false;
    }
}
