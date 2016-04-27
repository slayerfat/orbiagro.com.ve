<?php namespace Orbiagro\Http;

use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Orbiagro\Http\Middleware\Authenticate;
use Orbiagro\Http\Middleware\RedirectIfAuthenticated;
use Orbiagro\Http\Middleware\RedirectIfNotAdmin;
use Orbiagro\Http\Middleware\RedirectIfUnverified;
use Orbiagro\Http\Middleware\RedirectIfVerified;

/**
 * Class Kernel
 *
 * @package Orbiagro\Http
 */
class Kernel extends HttpKernel
{

    /**
     * The applications global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Orbiagro\Http\Middleware\VerifyCsrfToken::class,
        ],
        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The applications route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'            => Authenticate::class,
        'auth.basic'      => AuthenticateWithBasicAuth::class,
        'guest'           => RedirectIfAuthenticated::class,
        'user.verified'   => RedirectIfVerified::class,
        'user.unverified' => RedirectIfUnverified::class,
        'user.admin'      => RedirectIfNotAdmin::class,
        'throttle'        => ThrottleRequests::class,
    ];
}
