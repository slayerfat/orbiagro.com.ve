<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

  use DispatchesCommands, ValidatesRequests;

  protected function redirectToController($controller, $id, $message = null, $method = 'error')
  {
    $message = $message ? $message :'Ud. no tiene permisos para esta accion.';

    flash()->$method($message);
    return redirect()->action($controller, $id);
  }

}
