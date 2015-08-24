<?php namespace Orbiagro\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The applications global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Orbiagro\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The applications route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'            => \Orbiagro\Http\Middleware\Authenticate::class,
        'auth.basic'      => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'           => \Orbiagro\Http\Middleware\RedirectIfAuthenticated::class,
        'user.verified'   => \Orbiagro\Http\Middleware\RedirectIfVerified::class,
        'user.unverified' => \Orbiagro\Http\Middleware\RedirectIfUnverified::class,
        'user.admin'      => \Orbiagro\Http\Middleware\RedirectIfNotAdmin::class,
    ];
}
