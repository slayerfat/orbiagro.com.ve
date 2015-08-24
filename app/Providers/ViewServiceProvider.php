<?php namespace App\Providers;

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
            'App\Http\Composers\Visits@composePopularSubCats'
        );

        view()->composer(
            'sub-category.addons.visited',
            'App\Http\Composers\Visits@composeVisitedSubCats'
        );

        view()->composer(
            'visit.addons.relatedProducts',
            'App\Http\Composers\Visits@composeRelatedProducts'
        );

        view()->composer(
            'partials.carrusel-main',
            'App\Http\Composers\Carrusel@composeHomeCarruselImages'
        );

        view()->composer(
            'partials.orbiagro-info',
            'App\Http\Composers\OrbiagroInfo@composeInfo'
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
