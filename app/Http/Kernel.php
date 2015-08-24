<?php namespace Orbiagro\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'Orbiagro\Http\Middleware\VerifyCsrfToken',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'            => 'Orbiagro\Http\Middleware\Authenticate',
        'auth.basic'      => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest'           => 'Orbiagro\Http\Middleware\RedirectIfAuthenticated',
        'user.verified'   => 'Orbiagro\Http\Middleware\RedirectIfVerified',
        'user.unverified' => 'Orbiagro\Http\Middleware\RedirectIfUnverified',
        'user.admin'      => 'Orbiagro\Http\Middleware\RedirectIfNotAdmin',
    ];
}
