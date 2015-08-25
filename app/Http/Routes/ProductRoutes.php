<?php namespace Orbiagro\Http\Routes;

use Orbiagro\Http\Routes\Routes;

class ProductRoutes extends Routes
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
             * restaura a un producto en la base de datos
             */
            [
                'method' => 'post',
                'url' => 'productos/{productos}/restore',
                'data' => [
                    'uses' => 'ProductsController@restore',
                    'as' => 'products.restore'
                ]
            ],

            /**
             * restaura a un producto en la base de datos
             */
            [
                'method' => 'delete',
                'url' => 'productos/{productos}/forceDestroy',
                'data' => [
                    'uses' => 'ProductsController@forceDestroy',
                    'as' => 'products.destroy.force'
                ]
            ],

            /**
             * heroDetails de un Producto.
             */
            [
                'method' => 'post',
                'url' => 'productos/details/{productos}',
                'data' => [
                    'uses' => 'ProductsController@heroDetails',
                    'as' => 'products.details'
                ]
            ],

            /**
             * encontrar un listado de productos segun su categoria
             */
            [
                'method' => 'get',
                'url' => 'categorias/{categorias}/productos',
                'data' => [
                    'uses' => 'ProductsController@indexByCategory',
                    'as' => 'products.category.index'
                ]
            ],

            /**
             * encontrar un listado de productos segun su categoria
             */
            [
                'method' => 'get',
                'url' => 'rubros/{rubros}/productos',
                'data' => [
                    'uses' => 'ProductsController@indexBySubCategory',
                    'as' => 'products.subcategory.index'
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
            [
                'routerOptions' => [
                        'prefix' => 'productos',
                    ],
                'rtDetails' => [
                        'uses'     => 'ProductsController',
                        'as'       => 'product',
                        'resource' => '{productos}'
                    ]
            ],
        ];
    }
}
