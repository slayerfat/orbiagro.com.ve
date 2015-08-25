<?php namespace Orbiagro\Http\Routes;

use Orbiagro\Http\Routes\Routes;

class UserRoutes extends Routes
{

    /**
     * Genera una instancia de esta locura.
     *
     * @return void
     */
    public function __construct()
    {
        $this->options = $this->getRestfulOptions();
    }

    /**
     * Genera todas las rutas relacionadas con esta clase
     *
     * @return void
     */
    public function execute()
    {
        foreach ($this->options as $array) {
            $this->registerRESTfulGroup(
                $array['routerOptions'],
                $array['rtDetails']
            );
        }

        $this->registerSigleRoute($this->getNonRestfulOptions());

    }

    /**
     * Las rutas adicionales que no son por defecto.
     *
     * @return array
     */
    protected function getNonRestfulOptions()
    {
        return [
            /**
             * Productos de un usuario
             */
            [
                'method' => 'get',
                'url' => 'usuarios/{usuarios}/productos',
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
                'url' => 'usuarios/{usuarios}/restore',
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
                'url' => 'usuarios/eliminados/{usuarios}',
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
                'url' => 'usuarios/{usuarios}/confirmar-eliminacion',
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
                'url' => 'usuarios/{usuarios}/forceDestroy',
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
                'url' => 'usuarios/{usuarios}/visitas/productos',
                'data' => [
                    'uses' => 'UsersController@productVisits',
                    'as' => 'user.products.visits'
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getRestfulOptions()
    {
        return [
            /**
             * Usuarios
             */
            [
                'routerOptions' => [
                        'prefix' => 'usuarios',
                    ],
                'rtDetails' => [
                        'uses'     => 'UsersController',
                        'as'       => 'user',
                        'resource' => '{usuarios}'
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
                        'resource' => '{usuarios}'
                    ]
            ],
        ];
    }
}
