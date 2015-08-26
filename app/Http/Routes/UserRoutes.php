<?php namespace Orbiagro\Http\Routes;

/**
 * Class UserRoutes
 * @package Orbiagro\Http\Routes
 */
class UserRoutes extends Routes
{

    /**
     * Prueba
     * @var array
     */
    protected $restfulOptions = [
        [
            'routerOptions' => [
                    'prefix' => 'usuarios',
                ],
            'rtDetails' => [
                    'uses'     => 'UsersController',
                    'as'       => 'users',
                    'resource' => '{users}'
                ]
        ],
        /**
         * Datos Personales (Person)
         */
        [
            'routerOptions' => [
                    'prefix' => 'usuarios/datos-personales',
                ],
            'rtDetails' => [
                    'uses'     => 'PeopleController',
                    'as'       => 'users.people',
                    'resource' => '{users}'
                ]
        ],
    ];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * Productos de un usuario
         */
        [
            'method' => 'get',
            'url' => 'usuarios/{users}/productos',
            'data' => [
                'uses' => 'UsersController@products',
                'as' => 'users.products'
            ]
        ],

        /**
         * restaura al usuario en la base de datos
         */
        [
            'method' => 'post',
            'url' => 'usuarios/{users}/restore',
            'data' => [
                'uses' => 'UsersController@restore',
                'as' => 'users.restore'
            ]
        ],

        /**
         * Usuarios Eliminados
         */
        [
            'method' => 'get',
            'url' => 'usuarios/eliminados/{users}',
            'data' => [
                'uses' => 'UsersController@showTrashed',
                'as' => 'users.trashed'
            ]
        ],

        /**
         * UX de un usuario que quiere eliminar su cuenta
         *
         * @todo mejorar esto
         */
        [
            'method' => 'get',
            'url' => 'usuarios/{users}/confirmar-eliminacion',
            'data' => [
                'uses' => 'UsersController@preDestroy',
                'as' => 'users.destroy.pre'
            ]
        ],

        /**
         * Eliminar usuarios de DB
         */
        [
            'method' => 'delete',
            'url' => 'usuarios/{users}/forceDestroy',
            'data' => [
                'uses' => 'UsersController@forceDestroy',
                'as' => 'users.destroy.forced'
            ]
        ],

        /**
         * Visitas de productos de un usuario
         */
        [
            'method' => 'get',
            'url' => 'usuarios/{users}/visitas/productos',
            'data' => [
                'uses' => 'UsersController@productVisits',
                'as' => 'users.products.visits'
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
