<?php namespace Orbiagro\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    /**
     * Redirecciona al usuario a alguna ruta.
     *
     * @param  string $route
     * @param  mixed $id
     * @param  string $message el mensaje a mostrar al usuario.
     * @param  string $method  el tipo de mensaje a mostrar.
     * @return Response
     */
    protected function redirectToRoute($route, $id = null, $message = null, $method = 'error')
    {
        $message = $message ? $message :'Ud. no tiene permisos para esta accion.';

        flash()->$method($message);

        // añadida esta condicion para que no salga
        // en el url esto: /algo/otra-cosa?
        if (is_null($id)) {
            return redirect()->route($route);
        }

        return redirect()->route($route, $id);
    }
}
