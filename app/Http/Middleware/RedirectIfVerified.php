<?php namespace Orbiagro\Http\Middleware;

use Closure;

/**
 * Class RedirectIfVerified
 * @package Orbiagro\Http\Middleware
 */
class RedirectIfVerified
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user && $request->user()->isVerified()) {
            return redirect('/');
        }
        return $next($request);
    }
}
