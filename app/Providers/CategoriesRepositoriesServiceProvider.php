<?php namespace Orbiagro\Providers;

use Orbiagro\Models\Category;
use Illuminate\Support\ServiceProvider;
use Orbiagro\Repositories\CategoryRepository;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoriesRepositoriesServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new CategoryRepository($app[Category::class]);
        });
    }
}
