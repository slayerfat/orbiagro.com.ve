<?php namespace Orbiagro\Http\Routes;

use Route;

/**
 * @internal http://i.imgur.com/xVyoSl.jpg
 */

abstract class Routes
{
    /**
     * Las opciones para crear las rutas, segun cada tipo.
     *
     * @var array
     */
    protected $options;

    /**
     * @return void
     */
    abstract public function execute();

    /**
     * @return array
     */
    abstract protected function getRestfulOptions();

    /**
     * @return array
     */
    abstract protected function getNonRestfulOptions();

    /**
     * itera las opciones para registrar las rutas.
     *
     * @param  array  $options
     * @return void
     */
    protected function registerSigleRoute(array $options)
    {
        foreach ($options as $details) {
            Route::$details['method']($details['url'], $details['data']);
        }
    }

    /**
     * Registra un grupo de rutas.
     *
     * @param  array  $options Las opciones del grupo.
     * @param  array  $details Los parametros necesarios para registrar la ruta.
     *
     * @return void
     */
    protected function registerRESTfulGroup(array $options, array $details)
    {
        Route::group($options, function () use ($details) {
            Route::get(
                '/crear',
                [
                    'uses' => $details['uses'].'@create',
                    'as'   => $details['as'].'.create'
                ]
            );

            Route::post(
                '/',
                [
                    'uses' => $details['uses'].'@store',
                    'as'   => $details['as'].'.store'
                ]
            );

            Route::get(
                '/'.$details['resource'].'/editar',
                [
                    'uses' => $details['uses'].'@edit',
                    'as'   => $details['as'].'.edit'
                ]
            );

            Route::patch(
                '/'.$details['resource'],
                [
                    'uses' => $details['uses'].'@update',
                    'as'   => $details['as'].'.update'
                ]
            );

            Route::delete(
                '/'.$details['resource'],
                [
                    'uses' => $details['uses'].'@destroy',
                    'as'   => $details['as'].'.destroy'
                ]
            );
        });
    }
}
