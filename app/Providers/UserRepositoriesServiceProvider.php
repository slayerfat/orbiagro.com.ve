<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;
use Orbiagro\Models\Profile;
use Orbiagro\Models\User;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;
use Orbiagro\Repositories\Interfaces\UserConfirmationInterface;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;
use Orbiagro\Repositories\ProfileRepository;
use Orbiagro\Repositories\UserConfirmationRepository;
use Orbiagro\Repositories\UserRepository;

class UserRepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new UserRepository($app[User::class]);
        });

        $this->app->bind(ProfileRepositoryInterface::class, function ($app) {
            return new ProfileRepository($app[Profile::class]);
        });

        $this->app->bind(UserConfirmationInterface::class, function ($app) {
            return new UserConfirmationRepository(
                $app[UserRepositoryInterface::class],
                $app[ProfileRepositoryInterface::class],
                $app[UserConfirmation::class]
            );
        });
    }
}
