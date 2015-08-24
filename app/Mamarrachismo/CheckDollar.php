<?php namespace App\Mamarrachismo;

use Storage;
use Carbon\Carbon;

class CheckDollar
{

    /**
     * el dolar segun el dia/semana
     * @var stdClass object
     */
    public $dollar;

    /**
     * el euro segun el dia/semana
     * @var stdClass object
     */
    public $euro;

    /**
     * El promedio del dolar
     * @var stdClass object
     */
    public $promedio;

    /**
     * los datos de los APIs
     * @var stdClass object
     */
    private $data;

    /**
     * El objeto storage para manipular algun archivo
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    private $storage;

    /**
     * El objeto Carbon con el timestamp
     * @var \Carbon\Carbon
     */
    private $time;

    /**
     * la direccion del 'API' de dollarToday
     * @var string
     */
    private $dollarTodayUrl = 'https://s3.amazonaws.com/dolartoday/data.json';

    public function __construct()
    {
        $this->time = new Carbon;

        if (app()->environment() == 'testing') {
            return;
        }

        $this->storage = new Storage;

        if ($this->fileExists()) {
            $this->parseDollarTodayJson();

        } elseif ($this->makeFile()) {
            self::__construct();
        }

        return;
    }

    // --------------------------------------------------------------------------
    // Metodos Publicos
    // --------------------------------------------------------------------------

    /**
     * chequea si el objeto tiene data parseada de algun api.
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
     */
    public function getDollar()
    {
        $this->checkDollar();

        return $this->dollar;
    }

    /**
     * chequea si esta el archivo o no para ajustar el objeto
     * y sus atributos.
     *
     * @return boolean
     */
    private function parseDollarTodayJson()
    {
        $storage = $this->storage;

        if (!$this->fileExists()) {
            return $this->makeFile();
        }

        $this->data = json_decode($storage::get('dollar.json'));
        $this->dollar = $this->data->USD;
        $this->euro = $this->data->EUR;

        return true;
    }

    /**
     * chequea que el data en el objeto exista y devuelve el dolar
     */
    private function checkDollar()
    {
        if ($this->data) {
            $this->dollar = $this->data->USD;
            return true;
        }

        return $this->parseDollarTodayJson();
    }

    /**
     * chequea que el archivo como tal exista.
     */
    private function fileExists()
    {
        $storage = $this->storage;

        if ($storage::exists('dollar.json')) {
            if ($storage::size('dollar.json') > 0) {
                return true;
            }

            $storage::delete('dollar.json');

            return false;
        }
        return false;
    }

    /**
     * crea el archivo en el sistema y añade el timestamp local.
     */
    private function makeFile()
    {
        $storage = $this->storage;
        $data = file_get_contents($this->dollarTodayUrl);

        if (!$data) {
            return null;
        }

        $data = json_decode(utf8_decode($data));
        $data->local_timestamps = $this->time;
        $this->data = $data;
        $data = json_encode((array)$data);

        return $storage::put('dollar.json', $data);
    }
}
