<?php namespace Orbiagro\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package Orbiagro\Http\Controllers
 */
abstract class Controller extends BaseController
{

    use DispatchesJobs, ValidatesRequests;

    /**
     * Redirecciona al usuario a alguna ruta.
     *
     * @param  string $route
     * @param  mixed $id
     * @param  string $message el mensaje a mostrar al usuario.
     * @param  string $method el tipo de mensaje a mostrar.
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToRoute($route, $id = null, $message = null, $method = 'error')
    {
        $message = $message ? $message : 'Ud. no tiene permisos para esta acción.';

        flash()->$method($message);

        // añadida esta condicion para que no salga
        // en el url esto: /algo/otra-cosa?
        if (is_null($id)) {
            return redirect()->route($route);
        }

        return redirect()->route($route, $id);
    }

    /**
     * Crea un arreglo de imagenes utilizadas por facebook y su openGraph
     *
     * @param \Illuminate\Support\Collection $elements
     * @param int $amount
     * @return array
     */
    protected function makeOpenGraphImages($elements, $amount = 5)
    {
        // determinamos la cantidad, no mas de 5
        $picks = $elements->random($elements->count() >= $amount ? $amount : $elements->count())->load('image');
        $paths = [];
        if ($elements->count() > 1 || $elements->count() >= $amount) {
            foreach ($picks as $element) {
                $paths[] = asset($element->image->small);
            }

            return $paths;
        } elseif ($elements->count() == 1) {
            $paths[] = asset($picks->image->small);

            return $paths;
        }

        return $paths;
    }
}
