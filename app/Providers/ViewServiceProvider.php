<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'sub-category.addons.popular',
            'Orbiagro\Http\Composers\Visits@composePopularSubCats'
        );

        view()->composer(
            'sub-category.addons.visited',
            'Orbiagro\Http\Composers\Visits@composeVisitedSubCats'
        );

        view()->composer(
            'visit.addons.relatedProducts',
            'Orbiagro\Http\Composers\Visits@composeRelatedProducts'
        );

        view()->composer(
            'partials.carrusel-main',
            'Orbiagro\Http\Composers\Carrusel@composeHomeCarruselImages'
        );

        view()->composer(
            'partials.orbiagro-info',
            'Orbiagro\Http\Composers\OrbiagroInfo@composeInfo'
        );
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
