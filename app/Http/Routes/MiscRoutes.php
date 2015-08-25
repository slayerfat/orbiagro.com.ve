<?php namespace Orbiagro\Http\Routes;

use Orbiagro\Http\Routes\Routes;

class MiscRoutes extends Routes
{

    /**
     * @var array
     */
    protected $nonRestfulOptions = [
        [
            'method' => 'get',
            'url' => '/welcome',
            'data' => ['uses' => 'WelcomeController@index', 'as' => 'welcome']
        ],
        [
            'method' => 'get',
            'url' => '/',
            'data' => ['uses' => 'HomeController@index', 'as' => 'home']
        ],
    ];

    /**
     * Genera todas las rutas relacionadas con esta clase
     *
     * @return void
     */
    public function execute()
    {
        $this->registerSigleRoute($this->nonRestfulOptions);
    }
}
