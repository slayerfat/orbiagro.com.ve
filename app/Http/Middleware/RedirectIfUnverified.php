<?php namespace Orbiagro\Http\Middleware;

use Closure;

/**
 * Class RedirectIfUnverified
 *
 * @package Orbiagro\Http\Middleware
 */
class RedirectIfUnverified
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->hasConfirmation()) {
            flash()->warning('Ud. todavía no ha verificado su cuenta en el sistema.');

            return redirect()->route('users.unverified');
        }

        if ($request->user()->isDisabled()) {
            flash()->error('Cuenta desactivada, escribanos a contacto@orbiagro.com.ve si cree que es un error.');

            return redirect()->route('users.unverified');
        }

        return $next($request);
    }
}
