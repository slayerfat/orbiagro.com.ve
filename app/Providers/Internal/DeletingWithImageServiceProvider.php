<?php namespace Orbiagro\Providers\Internal;

use Illuminate\Support\ServiceProvider;
use Orbiagro\Mamarrachismo\Traits\Providers\ModelEventsTrait;
use Orbiagro\Models\Category;
use Orbiagro\Models\Maker;
use Orbiagro\Models\SubCategory;

class DeletingWithImageServiceProvider extends ServiceProvider
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
            Category::class,
            Maker::class,
            SubCategory::class,
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
