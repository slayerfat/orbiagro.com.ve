<?php namespace Orbiagro\Http\Routes;

/**
 * Class MiscRoutes
 *
 * @package Orbiagro\Http\Routes
 */
class MiscRoutes extends Routes
{

    /**
     * @var array
     */
    protected $restfulOptions = [
        /**
         * Maker
         */
        [
            'routerOptions' => [
                'prefix' => 'fabricantes',
            ],
            'rtDetails'     => [
                'uses'     => 'MakersController',
                'as'       => 'makers',
                'resource' => '{makers}',
            ],
        ],

        /**
         * Profiles
         */
        [
            'routerOptions' => [
                'prefix' => 'perfiles',
            ],
            'rtDetails'     => [
                'uses'     => 'ProfilesController',
                'as'       => 'profiles',
                'resource' => '{profiles}',
            ],
        ],

        /**
         * Provider
         */
        [
            'routerOptions' => [
                'prefix' => 'proveedores',
            ],
            'rtDetails'     => [
                'uses'     => 'ProvidersController',
                'as'       => 'providers',
                'resource' => '{providers}',
            ],
        ],

        /**
         * Image
         */
        [
            'routerOptions' => [
                'prefix' => 'imagenes',
            ],
            'rtDetails'     => [
                'uses'     => 'ImagesController',
                'as'       => 'images',
                'resource' => '{images}',
                'ignore'   => ['index', 'show', 'create', 'store'],
            ],
        ],

        /**
         * Image
         */
        [
            'routerOptions' => [
                'prefix' => 'promociones',
            ],
            'rtDetails'     => [
                'uses'     => 'PromotionsController',
                'as'       => 'promotions',
                'resource' => '{promotions}',
            ],
        ],
    ];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * sanity-check
         */
        [
            'method' => 'get',
            'url'    => '/welcome',
            'data'   => ['uses' => 'WelcomeController@index', 'as' => 'welcome'],
        ],
        /**
         * Home
         */
        [
            'method' => 'get',
            'url'    => '/',
            'data'   => ['uses' => 'HomeController@index', 'as' => '/'],
        ],
        [
            'method' => 'get',
            'url'    => 'home',
            'data'   => ['uses' => 'HomeController@index', 'as' => 'home'],
        ],

        /**
         * Ajax de Direcciones
         */
        [
            'method' => 'get',
            'url'    => 'direcciones/estados',
            'data'   => [
                'uses'       => 'DirectionsController@states',
                'as'         => 'api.states.index',
                'middleware' => 'auth',
            ],
        ],
        [
            'method' => 'get',
            'url'    => 'direcciones/estados/{states}/municipios',
            'data'   => [
                'uses'       => 'DirectionsController@towns',
                'as'         => 'api.states.towns.index',
                'middleware' => 'auth',
            ],
        ],
        [
            'method' => 'get',
            'url'    => 'direcciones/municipios/{towns}',
            'data'   => [
                'uses'       => 'DirectionsController@town',
                'as'         => 'api.towns.show',
                'middleware' => 'auth',
            ],
        ],
        [
            'method' => 'get',
            'url'    => 'direcciones/municipios/{towns}/parroquias',
            'data'   => [
                'uses'       => 'DirectionsController@parishes',
                'as'         => 'api.towns.parishes.index',
                'middleware' => 'auth',
            ],
        ],
        [
            'method' => 'get',
            'url'    => 'direcciones/parroquias/{parishes}',
            'data'   => [
                'uses'       => 'DirectionsController@parish',
                'as'         => 'api.parishes.show',
                'middleware' => 'auth',
            ],
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

        $this->registerControllerPrototype([
            'auth'     => 'Auth\AuthController',
            'password' => 'Auth\PasswordController',
        ]);
    }
}
