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
                'resource' => '{people}',
                'ignore' => ['create', 'edit', 'store']
            ]
        ],
    ];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * Usuarios Eliminados
         */
        [
            'method'   => 'get',
            'url'      => 'usuarios/eliminados/{users}',
            'data'     => [
                'uses' => 'UsersController@showTrashed',
                'as'   => 'users.trashed'
            ]
        ],

        /**
         * El resto de datos personales
         */
        [
            'method'   => 'get',
            'url'      => 'usuarios/datos-personales/{usuarios}/crear',
            'data'     => [
                'uses' => 'PeopleController@create',
                'as'   => 'users.people.create'
            ]
        ],
        [
            'method'   => 'get',
            'url'      => 'usuarios/datos-personales/{usuarios}/editar',
            'data'     => [
                'uses' => 'PeopleController@edit',
                'as'   => 'users.people.edit'
            ]
        ],
        [
            'method'   => 'post',
            'url'      => 'usuarios/datos-personales/{usuarios}',
            'data'     => [
                'uses' => 'PeopleController@store',
                'as'   => 'users.people.store'
            ]
        ],

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
