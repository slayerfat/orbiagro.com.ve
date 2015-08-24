<?php namespace Orbiagro\Http\Middleware;

use Closure;

class RedirectIfNotAdmin
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
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        flash()->error('Ud. no tiene permisos para esta acción.');
        return redirect()->back();
    }
}
