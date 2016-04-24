<?php namespace Orbiagro\Providers\Internal;

use Auth;
use Illuminate\Support\ServiceProvider;
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
            'Orbiagro\Models\Characteristic',
            'Orbiagro\Models\Feature',
            'Orbiagro\Models\MechanicalInfo',
            'Orbiagro\Models\Nutritional',
            'Orbiagro\Models\Bank',
            'Orbiagro\Models\CardType',
            'Orbiagro\Models\State',
            'Orbiagro\Models\Town',
            'Orbiagro\Models\Parish',
            'Orbiagro\Models\Promotion',
            'Orbiagro\Models\PromoType',
            'Orbiagro\Provider',
            'Orbiagro\Models\Gender',
            'Orbiagro\Models\Nationality',
            'Orbiagro\Models\Person',
            'Orbiagro\Models\Visit',
            'Orbiagro\Models\Billing',
            'Orbiagro\Models\Direction',
            'Orbiagro\Models\File',
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
