<?php namespace Orbiagro\Http\Routes;

/**
 * Class CategoriesRoutes
 * @package Orbiagro\Http\Routes
 */
class CategoriesRoutes extends Routes
{

    /**
     * @var array
     */
    protected $restfulOptions = [
        /**
         * Category
         */
        [
            'routerOptions'    => [
                    'prefix'   => 'categorias',
                ],
            'rtDetails'        => [
                    'uses'     => 'CategoriesController',
                    'as'       => 'cats',
                    'resource' => '{cats}'
                ]
        ],

        /**
         * SubCategory
         */
        [
            'routerOptions'    => [
                    'prefix'   => 'rubros',
                ],
            'rtDetails'        => [
                    'uses'     => 'SubCategoriesController',
                    'as'       => 'subCats',
                    'resource' => '{subCats}'
                ]
        ],
    ];

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        /**
         * listado de rubros segun su categoria
         */
        [
            'method'   => 'get',
            'url'      => 'categorias/{categorias}/rubros',
            'data'     => [
                'uses' => 'SubCategoriesController@indexByCategory',
                'as'   => 'cats.subCats.index'
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
