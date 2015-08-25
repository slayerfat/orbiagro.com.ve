<?php namespace Orbiagro\Http\Routes;

use Orbiagro\Http\Routes\Routes;

class MiscRoutes extends Routes
{

    /**
     * Genera una instancia de esta locura.
     *
     * @return void
     */
    public function __construct()
    {
        $this->options = $this->getNonRestfulOptions();
    }

    /**
     * Genera todas las rutas relacionadas con esta clase
     *
     * @return void
     */
    public function execute()
    {
        $this->registerSigleRoute($this->options);
    }

    /**
     * @return array
     */
    protected function getRestfulOptions()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getNonRestfulOptions()
    {
        return [
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
    }
}
