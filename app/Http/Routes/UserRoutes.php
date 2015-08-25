<?php namespace Orbiagro\Http\Routes;

use Orbiagro\Http\Routes\Routes;

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
                    'as'       => 'user',
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
                    'as'       => 'user.people',
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
                'as' => 'user.products'
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
                'as' => 'user.restore'
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
                'as' => 'user.trashed'
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
                'as' => 'user.destroy.pre'
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
                'as' => 'user.destroy.forced'
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
                'as' => 'user.products.visits'
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
        foreach ($this->restfulOptions as $array) {
            $this->registerRESTfulGroup(
                $array['routerOptions'],
                $array['rtDetails']
            );
        }

        $this->registerSigleRoute($this->nonRestfulOptions);

    }
}
