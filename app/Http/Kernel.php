<?php namespace Orbiagro\Http;

use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Orbiagro\Http\Middleware\Authenticate;
use Orbiagro\Http\Middleware\RedirectIfAuthenticated;
use Orbiagro\Http\Middleware\RedirectIfNotAdmin;
use Orbiagro\Http\Middleware\RedirectIfUnverified;
use Orbiagro\Http\Middleware\RedirectIfVerified;
use Orbiagro\Http\Middleware\VerifyCsrfToken;

/**
 * Class Kernel
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
        CheckForMaintenanceMode::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
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
    ];
}
