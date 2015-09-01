<?php namespace Orbiagro\Http\Routes;

/**
 * Class UserRoutes
 * @package Orbiagro\Http\Routes
 */
class ConfirmationsRoutes extends Routes
{

    /**
     * Prueba
     * @var array
     */
    protected $restfulOptions = [];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * usuario por verificar
         */
        [
            'method'         => 'get',
            'url'            => 'usuarios/por-verificar',
            'data'           => [
                'uses'       => 'HomeController@unverified',
                'as'         => 'users.unverified',
                'middleware' => 'user.verified',
            ]
        ],
        /**
         * para generar confirmaciones de usuario
         */
        [
            'method'         => 'get',
            'url'            => 'usuarios/generar-confirmacion',
            'data'           => [
                'uses'       => 'ConfirmationsController@createConfirm',
                'as'         => 'users.confirmations.create',
                'middleware' => 'user.verified',
            ]
        ],
        [
            'method'         => 'get',
            'url'            => 'usuarios/confirmar/{string}',
            'data'           => [
                'uses'       => 'ConfirmationsController@confirm',
                'as'         => 'users.confirmations.confirm',
                'middleware' => 'user.verified',
            ]
        ],
    ];

    /**
     * Genera todas las rutas relacionadas con esta clase
     *
     * @return void
     */
    public function execute()
    {
        $this->executePrototype(
            $this->restfulOptions,
            $this->nonRestfulOptions
        );
    }
}
