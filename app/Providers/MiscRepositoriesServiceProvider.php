<?php

namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;
use Orbiagro\Models\Promotion;
use Orbiagro\Models\PromoType;
use Orbiagro\Repositories\Interfaces\PromotionRepositoryInterface;
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
    }
}
