<?php namespace Orbiagro\Providers;

use Orbiagro\Models\User;
use Orbiagro\Models\Profile;
use Orbiagro\Models\Category;
use Orbiagro\Models\UserConfirmation;
use Illuminate\Support\ServiceProvider;
use Orbiagro\Repositories\UserRepository;
use Orbiagro\Repositories\ProfileRepository;
use Orbiagro\Repositories\CategoryRepository;
use Orbiagro\Repositories\UserConfirmationRepository;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;
use Orbiagro\Repositories\Interfaces\UserConfirmationInterface;
use Orbiagro\Repositories\Interfaces\ProfileRepositoryInterface;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // cats
        $this->app->bind(CategoryRepositoryInterface::class, function ($app) {
            return new CategoryRepository($app[Category::class]);
        });

        $this->registerUserRelated();
    }

    /**
     * Registra los repositorios especificos para los usuarios.
     */
    private function registerUserRelated()
    {
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
                return new UserRepository($app[User::class]);
        });

        $this->app->bind(ProfileRepositoryInterface::class, function ($app) {
            return new ProfileRepository($app[Profile::class]);
        });

        // user confirmation
        $this->app->bind(UserConfirmationInterface::class, function ($app) {
            return new UserConfirmationRepository(
                $app[UserRepositoryInterface::class],
                $app[ProfileRepositoryInterface::class],
                $app[UserConfirmation::class]
            );
        });
    }
}
