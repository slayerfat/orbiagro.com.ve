<?php namespace Orbiagro\Providers;

use Illuminate\Support\ServiceProvider;
use Orbiagro\Models\Category;
use Orbiagro\Models\User;
use Orbiagro\Models\UserConfirmation;
use Orbiagro\Repositories\CategoryRepository;
use Orbiagro\Repositories\Interfaces\CategoryRepositoryInterface;
use Orbiagro\Repositories\Interfaces\UserConfirmationInterface;
use Orbiagro\Repositories\Interfaces\UserRepositoryInterface;
use Orbiagro\Repositories\UserConfirmationRepository;
use Orbiagro\Repositories\UserRepository;

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

        // user confirmation
        $this->app->bind(UserConfirmationInterface::class, function ($app) {
            return new UserConfirmationRepository(
                $app[UserRepositoryInterface::class],
                $app[UserConfirmation::class]
            );
        });
    }
}
