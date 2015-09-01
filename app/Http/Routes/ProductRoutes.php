<?php namespace Orbiagro\Http\Routes;

/**
 * Class ProductRoutes
 * @package Orbiagro\Http\Routes
 */
class ProductRoutes extends Routes
{

    /**
     * @var array
     */
    protected $restfulOptions = [
        [
            'routerOptions'    => [
                    'prefix'   => 'productos',
                ],
            'rtDetails'        => [
                    'uses'     => 'ProductsController',
                    'as'       => 'products',
                    'resource' => '{products}'
                ]
        ],

        /**
         * Features
         *
         * @internal se separan porque tienen nombre de resource
         *           diferentes, lo que puede implicar alguna comprobacion
         */
        [
            'routerOptions'  => [
                'prefix'     => 'productos/distintivos',
                'middleware' => 'auth',
            ],
            'rtDetails' => [
                'uses'     => 'FeaturesController',
                'as'       => 'products.features',
                'resource' => '{features}',
                'ignore'   => ['index', 'show', 'create', 'store']
            ]
        ],
    ];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * restaura a un producto en la base de datos
         */
        [
            'method'   => 'post',
            'url'      => 'productos/{products}/restore',
            'data'     => [
                'uses' => 'ProductsController@restore',
                'as'   => 'products.restore'
            ]
        ],

        /**
         * restaura a un producto en la base de datos
         */
        [
            'method'   => 'delete',
            'url'      => 'productos/{products}/forceDestroy',
            'data'     => [
                'uses' => 'ProductsController@forceDestroy',
                'as'   => 'products.destroy.force'
            ]
        ],

        /**
         * heroDetails de un Producto.
         */
        [
            'method'   => 'post',
            'url'      => 'productos/details/{products}',
            'data'     => [
                'uses' => 'ProductsController@heroDetails',
                'as'   => 'products.details'
            ]
        ],

        /**
         * encontrar un listado de productos segun su categoria
         */
        [
            'method'   => 'get',
            'url'      => 'categorias/{cats}/productos',
            'data'     => [
                'uses' => 'ProductsController@indexByCategory',
                'as'   => 'products.cats.index'
            ]
        ],

        /**
         * encontrar un listado de productos segun su categoria
         */
        [
            'method'   => 'get',
            'url'      => 'rubros/{subcats}/productos',
            'data'     => [
                'uses' => 'ProductsController@indexBySubCategory',
                'as'   => 'products.subcats.index'
            ]
        ],

        /**
         * MechanicalInfo
         *
         * se hace asi porque posee un controlador generico.
         */
        [
            'method'   => 'get',
            'url'      => 'productos/{products}/info-mecanica/crear',
            'data'     => [
                'uses' => 'RelatedProductModelsController@createMechInfo',
                'as'   => 'products.mechanicals.create'
            ]
        ],
        [
            'method'   => 'post',
            'url'      => 'productos/{products}/info-mecanica',
            'data'     => [
                'uses' => 'RelatedProductModelsController@storeMechInfo',
                'as'   => 'products.mechanicals.store'
            ]
        ],
        [
            'method'   => 'get',
            'url'      => 'productos/info-mecanica/{mechanicals}/editar',
            'data'     => [
                'uses' => 'RelatedProductModelsController@editMechInfo',
                'as'   => 'products.mechanicals.edit'
            ]
        ],
        [
            'method'   => 'patch',
            'url'      => 'productos/info-mecanica/{mechanicals}',
            'data'     => [
                'uses' => 'RelatedProductModelsController@updateMechInfo',
                'as'   => 'products.mechanicals.update'
            ]
        ],

        /**
         * characteristics
         */
        [
            'method'   => 'get',
            'url'      => 'productos/{products}/caracteristicas/crear',
            'data'     => [
                'uses' => 'RelatedProductModelsController@createCharacteristic',
                'as'   => 'products.characteristics.create'
            ]
        ],
        [
            'method'   => 'post',
            'url'      => 'productos/{products}/caracteristicas',
            'data'     => [
                'uses' => 'RelatedProductModelsController@storeCharacteristic',
                'as'   => 'products.characteristics.store'
            ]
        ],
        [
            'method'   => 'get',
            'url'      => 'productos/caracteristicas/{characteristics}/editar',
            'data'     => [
                'uses' => 'RelatedProductModelsController@editCharacteristic',
                'as'   => 'products.characteristics.edit'
            ]
        ],
        [
            'method'   => 'patch',
            'url'      => 'productos/caracteristicas/{characteristics}',
            'data'     => [
                'uses' => 'RelatedProductModelsController@updateCharacteristic',
                'as'   => 'products.characteristics.update'
            ]
        ],

        /**
         * Nutritional
         */
        [
            'method'   => 'get',
            'url'      => 'productos/{products}/valores-nutricionales/crear',
            'data'     => [
                'uses' => 'RelatedProductModelsController@createNutritional',
                'as'   => 'products.nutritionals.create'
            ]
        ],
        [
            'method'   => 'post',
            'url'      => 'productos/{products}/valores-nutricionales',
            'data'     => [
                'uses' => 'RelatedProductModelsController@storeNutritional',
                'as'   => 'products.nutritionals.store'
            ]
        ],
        [
            'method'   => 'get',
            'url'      => 'productos/valores-nutricionales/{nutritionals}/editar',
            'data'     => [
                'uses' => 'RelatedProductModelsController@editNutritional',
                'as'   => 'products.nutritionals.edit'
            ]
        ],
        [
            'method'   => 'patch',
            'url'      => 'productos/valores-nutricionales/{nutritionals}',
            'data'     => [
                'uses' => 'RelatedProductModelsController@updateNutritional',
                'as'   => 'products.nutritionals.update'
            ]
        ],

        /**
         * Providers
         */
        [
            'method'   => 'get',
            'url'      => 'productos/{products}/proveedores/crear',
            'data'     => [
                'uses' => 'ProductsProvidersController@create',
                'as'   => 'products.providers.create'
            ]
        ],
        [
            'method'   => 'post',
            'url'      => 'productos/{products}/proveedores',
            'data'     => [
                'uses' => 'ProductsProvidersController@store',
                'as'   => 'products.providers.store'
            ]
        ],
        [
            'method'   => 'get',
            'url'      => 'productos/proveedores/{products}/{providers}/editar',
            'data'     => [
                'uses' => 'ProductsProvidersController@edit',
                'as'   => 'products.providers.edit'
            ]
        ],
        [
            'method'   => 'patch',
            'url'      => 'productos/proveedores/{products}/{providers}',
            'data'     => [
                'uses' => 'ProductsProvidersController@update',
                'as'   => 'products.providers.update'
            ]
        ],
        [
            'method'   => 'delete',
            'url'      => 'productos/proveedores/{products}/{providers}',
            'data'     => [
                'uses' => 'ProductsProvidersController@destroy',
                'as'   => 'products.providers.destroy'
            ]
        ],

        /**
         * Imagenes
         */
        [
            'method'   => 'get',
            'url'      => 'productos/{productos}/imagenes/crear',
            'data'     => [
                'uses' => 'ImagesController@createProduct',
                'as'   => 'products.images.create'
            ]
        ],
        [
            'method'   => 'post',
            'url'      => 'productos/{productos}/imagenes',
            'data'     => [
                'uses' => 'ImagesController@storeProduct',
                'as'   => 'products.images.store'
            ]
        ],

        /**
         * Feature Create/Store
         */
        [
            'method'         => 'get',
            'url'            => 'productos/{products}/distintivos/crear',
            'data'           => [
                'uses'       => 'FeaturesController@create',
                'as'         => 'products.features.create',
                'middleware' => 'auth'
            ]
        ],
        [
            'method'         => 'post',
            'url'            => 'productos/{products}/distintivos',
            'data'           => [
                'uses'       => 'FeaturesController@store',
                'as'         => 'products.features.store',
                'middleware' => 'auth'
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
