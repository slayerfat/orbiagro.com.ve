<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;

use Orbiagro\Mamarrachismo\Traits\Providers\ModelEventsTrait;

class DelitingWithImageServiceProvider extends ServiceProvider
{

    use ModelEventsTrait;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $models = [
            Orbiagro\Models\Category::class,
            Orbiagro\Models\Maker::class,
            Orbiagro\Models\SubCategory::class,
        ];

        foreach ($models as $namespace) {
            $this->deleteEventsWithImage($namespace);
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
