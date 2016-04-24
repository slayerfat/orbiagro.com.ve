<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;
use Orbiagro\Models\Image;
use Orbiagro\Models\Maker;
use Orbiagro\Models\Profile;
use Orbiagro\Models\Promotion;
use Orbiagro\Models\PromoType;
use Orbiagro\Repositories\ImageRepository;
use Orbiagro\Repositories\Interfaces\ImageRepositoryInterface;
use Orbiagro\Repositories\Interfaces\MakerRepositoryInterface;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;
use Orbiagro\Repositories\Interfaces\PromotionRepositoryInterface;
use Orbiagro\Repositories\MakerRepository;
use Orbiagro\Repositories\ProfileRepository;
use Orbiagro\Repositories\PromotionRepository;

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

        $this->app->bind(ProfileRepositoryInterface::class, function ($app) {
            return new ProfileRepository($app[Profile::class]);
        });
    }
}
