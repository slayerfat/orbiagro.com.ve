<?php namespace App\Mamarrachismo;

use Storage;
use Carbon\Carbon;

class CheckDollar {

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

  public $promedio;

  /**
   * @var array
   */
  public $errors = [];

  /**
   * los datos de los APIs
   * @var stdClass object
   */
  private $data;

  /**
   * la direccion del 'API' de dollarToday
   * @var string
   */
  private $dollarTodayUrl = 'https://s3.amazonaws.com/dolartoday/data.json';

  public function __construct()
  {
    if($this->checkFileExists()):
      $this->parseDollarTodayJson();
    elseif($this->makeFile()):
      self::__construct();
    else:
      $this->errors[] = ['Error, no se puede chequear dolar.'];
    endif;
  }

  // --------------------------------------------------------------------------
  // Metodos Publicos
  // --------------------------------------------------------------------------

  /**
   * chequea si el objeto tiene data parseada de algun api.
   */
  public function isValid()
  {
    if(isset($this->data)) return true;
    return false;
  }

  /**
   * invoca a checkDollar y regresa mamarrachamente regresa dollar
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
    if($this->checkfileExists()):
      $this->data = json_decode(Storage::get('dollar.json'));
      $this->dollar = $this->data->USD;
      $this->euro = $this->data->EUR;
      return true;
    else:
      return $this->makeFile();
    endif;
  }

  /**
   * chequea que el data en el objeto exista y devuelve el dolar
   */
  private function checkDollar()
  {
    if($this->data):
      $this->dollar = $this->data->USD;
      return true;
    else:
      return $this->parseDollarTodayJson();
    endif;
  }

  /**
   * chequea que el archivo como tal exista.
   */
  private function checkFileExists()
  {
    if(Storage::exists('dollar.json')) return true;
    return false;
  }

  /**
   * crea el archivo en el sistema y añade el timestamp local.
   */
  private function makeFile()
  {
    $data = file_get_contents($this->dollarTodayUrl);
    if(!$data) return null;
    $data = json_decode($data);
    $data->local_timestamps = Carbon::now();
    $this->data = $data;
    $data = json_encode($data);
    Storage::put('dollar.json', $data);
    return true;
  }
}
