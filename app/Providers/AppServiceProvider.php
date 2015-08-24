<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Registrar;
use Laracasts\Generators\GeneratorsServiceProvider;
use Orbiagro\Services\Registrar as OrbiagroRegistrar;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(GeneratorsServiceProvider::class);
        }
        $this->app->bind(
            Registrar::class,
            OrbiagroRegistrar::class
        );
    }
}
