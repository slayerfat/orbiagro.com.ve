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
     * @example     Deberia contener un array con
     *              'routerOptions' => [
     *                  'prefix' => 'productos'
     *              ],
     *              'rtDetails' => [
     *                  'uses'     => 'ProductsController',
     *                  'as'       => 'product',
     *                  'resource' => '{productos}',
     *                  'ignore'   => null
     *              ]
     *
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
            $defaults = [
                'create'  => ['get', '/crear'],
                'store'   => ['post', '/'],
                'edit'    => ['get', '/'.$details['resource'].'/editar'],
                'update'  => ['patch', '/'.$details['resource']],
                'destroy' => ['delete', '/'.$details['resource']],
            ];

            // si en los detalles hay ignore, se salta.
            // es decir, si hay ignore, se ignora el metodo/ruta
            if (isset($details['ignore'])) {
                $defaults = array_except($defaults, $details['ignore']);
            }

            foreach ($defaults as $name => $rule) {
                /**
                 * rule[0] es el metodo
                 * rule[1] es el url
                 *
                 * @example Route::rule[0](rule[1], ...)
                 *          Route::create('/',      ...)
                 */
                Route::$rule[0](
                    $rule[1],
                    [
                        'uses' => $details['uses'].'@'.$name,
                        'as'   => $details['as'].'.'.$name
                    ]
                );
            }
        });
    }
}
