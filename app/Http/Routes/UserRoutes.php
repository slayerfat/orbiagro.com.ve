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
        $this->options = $this->getDefaulOptions();
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

        $this->registerSigleRoute([
            [
                'method' => 'get',
                'url' => '/welcome',
                'data' => ['uses' => 'WelcomeController@index', 'as' => 'welcome']
            ]
        ]);
    }

    /**
     * @return array
     */
    protected function getDefaulOptions()
    {
        return [
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
        ];
    }
}
