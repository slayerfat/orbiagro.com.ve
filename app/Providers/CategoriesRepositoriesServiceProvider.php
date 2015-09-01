<?php namespace Orbiagro\Providers;

use Orbiagro\Models\Category;
use Orbiagro\Models\SubCategory;
use Illuminate\Support\ServiceProvider;
use Orbiagro\Repositories\CategoryRepository;
use Orbiagro\Repositories\SubCategoryRepository;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;

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

        $this->app->bind(SubCategoryRepositoryInterface::class, function ($app) {
            return new SubCategoryRepository(
                $app[SubCategory::class],
                $app[CategoryRepositoryInterface::class]
            );
        });
    }
}
