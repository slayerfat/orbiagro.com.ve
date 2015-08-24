<?php namespace Orbiagro\Providers\Internal;

use Illuminate\Support\ServiceProvider;

use Auth;

use Orbiagro\Mamarrachismo\Traits\Providers\ModelEventsTrait;

class CreateAndUpdateModelServiceProvider extends ServiceProvider
{

    use ModelEventsTrait;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$id = Auth::id()) {
            return;
        }

        $models = [
            'App\Characteristic',
            'App\Feature',
            'App\MechanicalInfo',
            'App\Nutritional',
            'App\Bank',
            'App\CardType',
            'App\State',
            'App\Town',
            'App\Parish',
            'App\Promotion',
            'App\PromoType',
            'App\Provider',
            'App\Gender',
            'App\Nationality',
            'App\Person',
            'App\Visit',
            'App\Billing',
            'App\Direction',
            'App\File',
        ];

        foreach ($models as $namespace) {
            $this->creatingAndUpdatingEvents($namespace, $id);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
