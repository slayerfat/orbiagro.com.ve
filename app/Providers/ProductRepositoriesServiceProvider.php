<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;
use Orbiagro\Models\Feature;
use Orbiagro\Models\Product;
use Orbiagro\Repositories\FeatureRepository;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\FeatureRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProductRepositoryInterface;
use Orbiagro\Repositories\Interfaces\SubCategoryRepositoryInterface;
use Orbiagro\Repositories\ProductRepository;

class ProductRepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FeatureRepositoryInterface::class, function ($app) {
            return new FeatureRepository($app[Feature::class]);
        });

        $this->app->bind(ProductRepositoryInterface::class, function ($app) {
            return new ProductRepository(
                $app[Product::class],
                $app[CategoryRepositoryInterface::class],
                $app[SubCategoryRepositoryInterface::class]
            );
        });
    }
}
