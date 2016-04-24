<?php namespace Orbiagro\Mamarrachismo;

use Carbon\Carbon;
use Storage;

class CheckDollar
{

    /**
     * el dolar segun el dia/semana
     *
     * @var \stdClass object
     */
    public $dollar;

    /**
     * el euro segun el dia/semana
     *
     * @var \stdClass object
     */
    public $euro;

    /**
     * El promedio del dolar
     *
     * @var \stdClass object
     */
    public $promedio;

    /**
     * los datos de los APIs
     *
     * @var \stdClass object
     */
    private $data;

    /**
     * El objeto Carbon con el timestamp
     *
     * @var \Carbon\Carbon
     */
    private $time;

    /**
     * la direccion del 'API' de dollarToday
     *
     * @var string
     */
    private $dollarTodayUrl = 'https://s3.amazonaws.com/dolartoday/data.json';

    /**
     * @param Carbon $carbon
     */
    public function __construct(Carbon $carbon)
    {
        $this->time = $carbon;

        if (app()->environment() == 'testing') {
            $this->data             = $this->dollar = new \stdClass;
            $this->dollar->promedio = 1;
            return;
        }

        if ($this->fileExists()) {
            $this->parseDollarTodayJson();

        } elseif ($this->makeFile()) {
            self::__construct($carbon);
        }

        return;
    }

    /**
     * chequea que el archivo como tal exista.
     *
     * @return boolean
     */
    private function fileExists()
    {
        if (Storage::disk('local')->exists('dollar.json')) {
            if (Storage::disk('local')->size('dollar.json') > 0) {
                return true;
            }

            Storage::disk('local')->delete('dollar.json');

            return false;
        }

        return false;
    }

    /**
     * chequea si esta el archivo o no para ajustar el objeto
     * y sus atributos.
     *
     * @return boolean
     */
    private function parseDollarTodayJson()
    {
        if (!$this->fileExists()) {
            return $this->makeFile();
        }

        $this->data   = json_decode(Storage::disk('local')->get('dollar.json'));
        $this->dollar = $this->data->USD;
        $this->euro   = $this->data->EUR;

        return true;
    }

    /**
     * crea el archivo en el sistema y añade el timestamp local.
     *
     * @return boolean
     */
    private function makeFile()
    {
        $data = file_get_contents($this->dollarTodayUrl);

        if (!$data) {
            return null;
        }

        $data                   = json_decode(utf8_decode($data));
        $data->local_timestamps = $this->time;
        $this->data             = $data;
        $data                   = json_encode((array)$data);

        return Storage::disk('local')->put('dollar.json', $data);
    }

    /**
     * chequea si el objeto tiene data parseada de algun api.
     *
     * @return boolean
     */
    public function isValid()
    {
        if (isset($this->data)) {
            return true;
        }

        return false;
    }

    /**
     * invoca a checkDollar y regresa mamarrachamente dollar
     *
     * @todo MEJORAR ESTE METODO.
     *
     * @return \stdClass
     */
    public function getDollar()
    {
        $this->checkDollar();

        return $this->dollar;
    }

    /**
     * chequea que el data en el objeto exista y devuelve el dolar
     *
     * @return boolean
     */
    private function checkDollar()
    {
        if ($this->data) {
            $this->dollar = $this->data->USD;

            return true;
        }

        return $this->parseDollarTodayJson();
    }
}
