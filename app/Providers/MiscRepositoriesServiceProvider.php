<?php namespace Orbiagro\Providers;

use Orbiagro\Models\Image;
use Orbiagro\Models\Maker;
use Orbiagro\Models\Promotion;
use Orbiagro\Models\PromoType;
use Illuminate\Support\ServiceProvider;
use Orbiagro\Repositories\ImageRepository;
use Orbiagro\Repositories\Interfaces\MakerRepositoryInterface;
use Orbiagro\Repositories\MakerRepository;
use Orbiagro\Repositories\PromotionRepository;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;
use Orbiagro\Repositories\Interfaces\ImageRepositoryInterface;
use Orbiagro\Repositories\Interfaces\PromotionRepositoryInterface;

class MiscRepositoriesServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PromotionRepositoryInterface::class, function ($app) {
            return new PromotionRepository($app[PromoType::class], $app[Promotion::class]);
        });

        $this->app->bind(ImageRepositoryInterface::class, function ($app) {
            return new ImageRepository($app[Image::class], $app[Upload::class]);
        });

        $this->app->bind(MakerRepositoryInterface::class, function ($app) {
            return new MakerRepository($app[Maker::class]);
        });
    }
}
